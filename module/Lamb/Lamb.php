<?php
final class Lamb
{
	const DIR = 'module/Lamb/';
	private $running = true;
	private $is_idle = true;
	
	/**
	 * LastMessage_Server
	 * @var Lamb_Server
	 */
	private $lm_server = NULL;
	private $lm_origin = NULL;
	
	private $timers = array();
	
	private static $instance = NULL;
	/**
	 * @return Lamb
	 */
	public static function instance()
	{
		return self::$instance;
	} 

	private $modules = array();
	private $servers = array();

	public function __construct()
	{
		self::$instance = $this;
	}
	
	public function getModules()
	{
		return $this->modules;
	}
	
	public function getServers()
	{
		return $this->servers;
	}
	
	private function sumUptime()
	{
		$total = GWF_Settings::getSetting('_lamb3_uptime');
		$total += GWF_Settings::getSetting('_lamb3_shutdowntime') - GWF_Settings::getSetting('_lamb3_startuptime');
		GWF_Settings::setSetting('_lamb3_uptime', $total);
	}
	
	public function init()
	{
		$t = microtime(true);
		
		$this->sumUptime();
		
		GWF_Settings::setSetting('_lamb3_startuptime', microtime(true));
		
		$hosts = array_map('trim', explode(';', LAMB_SERVERS));
		$nicks = array_map('trim', explode(';', LAMB_NICKNAMES));
		$passs = array_map('trim', explode(';', LAMB_PASSWORDS));
		$chans = array_map('trim', explode(';', LAMB_CHANNELS));
		$admin = array_map('trim', explode(';', LAMB_ADMINS));
		
		foreach ($hosts as $i => $host)
		{
			if ($host === '') {
				continue;
			}
			$server = new Lamb_Server($host, $nicks[$i], $passs[$i], $chans[$i], $admin[$i]);
			$server->saveConfigVars($host, $nicks[$i], $chans[$i], $passs[$i], $admin[$i]);
			$this->addServer($server);
		}
		
		if (count($this->servers) === 0) {
			echo "Please add some servers to the config!\n";
			return false;
		}
		
		$this->initModules($server);
		
		# fix timers
		$t = microtime(true) - $t;
		foreach ($this->timers as $i => $timer)
		{
			$this->timers[$i][3] += $t;
		}
		
		return true;
	}
	
	private function initModules(Lamb_Server $server)
	{
		Lamb_Log::log('Lamb::initModules()');
		foreach (explode(';', LAMB_MODULES) as $module_name)
		{
			$this->initModule($server, $module_name);
		}
	}
	
	private function initModule(Lamb_Server $server, $module_name)
	{
		Lamb_Log::log(sprintf('Lamb::initModule(%s)', $module_name));
		
		$module_dir = self::DIR.sprintf('lamb_module/%s', $module_name);
		if (!Common::isDir($module_dir)) {
			Lamb_Log::log(sprintf('Lamb::initModule(%s) failed. Directory not found.', $module_name).PHP_EOL);
			return;
		}
		$module_file = self::DIR.sprintf('lamb_module/%s/Mod_%s.php', $module_name, $module_name);
		if (!Common::isFile($module_file)) {
			Lamb_Log::log(sprintf('Lamb::initModule(%s) failed: File not found.', $module_name).PHP_EOL);
			return;
		}
		
		require_once $module_file;
		
		$classname = sprintf('LambModule_%s', $module_name);
		if (!class_exists($classname)) {
			Lamb_Log::log(sprintf('Lamb::initModule(%s) failed: Class not found.', $module_name).PHP_EOL);
			return;
		}
		
		$module = new $classname();
		
		$module instanceof Lamb_Module;
		
		$module->setName($module_name);
		
		$module->onInit($server);
		
		$module->onInstall();
		
		$this->modules[] = $module;
	}

	public function mainloop()
	{
		while ($this->running)
		{
			$this->is_idle = true;
			
			foreach ($this->servers as $serverid => $server)
			{
				$this->processServer($server);
			}
			
			$this->processTimers();
			
//			$this->processSTDIN();
			
			if ($this->is_idle)
			{
				usleep(LAMB_SLEEP_MILLIS * 1000);
			}
			
			GWF_Settings::setSetting('_lamb3_shutdowntime', microtime(true));
		}
	}
	
	private function processSTDIN()
	{
//		$line = fscanf(STDIN, "%s".PHP_EOL);
//		$line = trim($line[0]);
//		if (!preg_match('/[ a-z_0-9]/i', $line)) {
//			return;
//		}
//		echo "Haha! You said $line!\n";
	}
	
	public function addTimer($server, $callback, $args, $microtime)
	{
		$this->timers[] = array($server, $callback, $args, $microtime+microtime(true));
	}
	
	private function processTimers()
	{
		$now = microtime(true);
		foreach ($this->timers as $i => $timer)
		{
			list($server, $callback, $args, $microtime) = $timer;
			if ($microtime <= $now)
			{
				unset($this->timers[$i]);
				call_user_func($callback, $server, $args);
			}
		}
	}
	
	public function processTimerPlugins(Lamb_Server $server, $args)
	{
		$path = self::DIR.'lamb_timer';
		if (false !== ($dir = dir($path)))
		{
			while (false !== ($entry = $dir->read()))
			{
				if (Common::endsWith($entry, '.php'))
				{
					include "$path/$entry";
				}
			}
			$dir->close();
		}
		else {
			echo "Cannot read timers dir!\n";
		}
		
		foreach ($this->modules as $module)
		{
			$module->onTimer($server);
		}
		
		// Add timer again
		$this->addTimer($server, array($this, 'processTimerPlugins'), NULL, LAMB_TIMER_INTERVAL);
	}
	
	private function processServer(Lamb_Server $server)
	{
		$this->lm_server = $server;
		$c = $server->getConnection();
		if ($c->isConnected())
		{
			while (true)
			{
				$msg = $c->getMessage();
				if ($msg === false) {
					break;
				}
				if ($msg === '') {
					break;
				}
				$this->processMessage($server, $msg);
				$this->is_idle = false;
			}
		}
		else
		{
			if (false === $server->connect()) {
				$this->removeServer($server);
			}
		}
	}
	
	/**
	 * Process a message generated by scripts, like eval.
	 * It`s a costy function, simulates a complete message processing, originated/permission by the original user.
	 * @param Lamb_Server $server
	 * @param string $message
	 */
	public function processMessageA(Lamb_Server $server, $message, $from)
	{
		return $this->processMessage($server, sprintf(":%s PRIVMSG %s :%s\r\n", $from, $this->lm_origin, $message));
	}
	
	private function processMessage(Lamb_Server $server, $message)
	{
		if ('' === ($message = trim($message))) {
			return;
		}
		
		Lamb_Log::log($message);
		
		# NEW
		$by_space = explode(' ', $message);
		if ($message{0} === ':')
		{
			$from = ltrim(array_shift($by_space), ':');
		}
		else
		{
			$from = '';
		}
		
		$command = array_shift($by_space);
		
		$args = array();
		while (count($by_space) > 0)
		{
			$arg = array_shift($by_space);
			if ($arg{0} === ':') {
				$args[] = trim(substr($arg, 1).' '.implode(' ', $by_space));
				break;
			}
			else {
				$args[] = $arg;
			}
		}

		# OLD
//		$by_colon = explode(':', $message, (($message{0} === ':') ? 3 : 2));
//		if ($by_colon[0] === '')
//		{
//			$split = explode(' ', $by_colon[1]);
//			if (isset($by_colon[2])) {
//				$split[count($split)-1] = $by_colon[2];
//			}
//			$from = array_shift($split);
//		}
//		else
//		{ 
//			$split = explode(' ', $by_colon[0]);
//			if (isset($by_colon[1])) {
//				$split[count($split)-1] = $by_colon[1];
//			}
//			$from = $server->getConnection()->getHostname();
//		}
//		
//		$command = array_shift($split);
//		$args = $split;

		$this->processCommand($server, $command, $from, $args);
	}
	
	
	private function processCommand(Lamb_Server $server, $command, $from, array $args)
	{
		if (strpos($command, '..') !== false) {
			echo "Rouge IRCD: $command\n";
			return;
		}
		
		$event_filename = self::DIR.sprintf('lamb_event/%s.php', $command);
		
		$server->setFrom($from);
		
		if (Common::isFile($event_filename))
		{
			$bot = $this;
			include $event_filename;
			foreach ($this->modules as $module)
			{
				$module->onEvent($bot, $server, $command, $from, $args);
			}
		}
		else
		{
			echo "=== UNKNOWN EVENT ===".PHP_EOL;
			Lamb_Log::debugCommand($server, $command, $from, $args);
		}
	}
	
	public function removeServer(Lamb_Server $server)
	{
		$sid = $server->getID();
		foreach ($this->servers as $i => $s)
		{
			if ($s->getID() === $sid)
			{
				unset($this->servers[$i]);
				$server->disconnect();
				
				$this->running = count($this->servers) > 0;
				
				return true;
			}
		}
		return false;
	}
	
	public function addServer(Lamb_Server $server)
	{
		$sid = $server->getID();
		if (false !== $this->getServer($sid)) {
			return false;
		}
		$this->servers[$sid] = $server;
		$this->addTimer($server, array($this, 'processTimerPlugins'), NULL, LAMB_TIMER_INTERVAL);
		return true;
	}
	
	/**
	 * @param int $serverid
	 * @return Lamb_Server
	 */
	public function getServer($serverid)
	{
		$serverid = (int)$serverid;
		if (!isset($this->servers[$serverid])) {
			return false;
		}
		return $this->servers[$serverid];
	}
	
	public function onPrivmsg(Lamb_Server $server, $from, $origin, $message)
	{
		if (false === ($user = $server->getUserFromOrigin($from, $origin))) {
			return;
		}
		
		$user->saveVars(array(
			'lusr_last_channel' => $origin,
			'lusr_last_message' => $message,
//			'lusr_last_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'lusr_timestamp' => time(),
		));
		
		$this->lm_origin = $origin;
		
		$message = preg_replace('/[ ]{2,}/', ' ', $message);
		
		$x01 = "\x01";
		if ( (Common::startsWith($message, $x01)) && (Common::endsWith($message, $x01)) ) {
			$this->onCTCP($server, $user, $from, $origin, substr($message, 1, -1));
		}
		else {
			$this->onPrivmsgModules($server, $user, $from, $origin, $message);
		}
	}
	
	public function onCTCP(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$cmd = strtolower(Common::substrUntil($message, ' ', $message));
		$msg = Common::substrFrom($message, ' ', $message);
		switch ($cmd)
		{
			case "ping":
				break;
			case "time":
				break;
			case "action":
				break;
			case "finger":
				break;
			case 'version':
				$server->sendCTCPReply($user->getName(), sprintf('VERSION Lamb v%s. http://lamb.gizmore.org', LAMB_VERSION));
				break; 
		}
		
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onCTPC($server, $user, $from, $origin, $message);
		}
	}
	
	public function onPrivmsgModules(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onPrivmsg($server, $user, $from, $origin, $message);
		}
	}
	
	public static function getPluginDirs()
	{
		$back = array();
		self::getPluginDirsR(self::DIR.'lamb_plugin', $back);
		return $back;
	}
	
	private static function getPluginDirsR($path, array &$back)
	{
		if (false === ($dir = dir($path))) {
			return false;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			if ($entry[0]==='.') {
				continue;
			}
			$fullpath = $path.'/'.$entry;
			if (Common::isDir($fullpath))
			{
				$back[] = $fullpath;
				self::getPluginDirsR($fullpath, $back);
			}
		}
		
		$dir->close();
	}

	public function onTrigger(Lamb_Server $server, $from, $origin, $message)
	{
		if (false === ($user = $server->getUserFromOrigin($from))) {
			return;
		}
		
		$this->lm_origin = $origin;
		
		$is_admin = $user->isLoggedIn() && $server->isAdminUsername($user->getName());
		
		$message = preg_replace('/[ ]{2,}/', ' ', $message);
		$message = ltrim($message, LAMB_TRIGGER);
		$command = Common::substrUntil($message, ' ');
		$message = Common::substrFrom($message, ' ', '');
		
		foreach (Lamb_User::$PRIVS as $priv)
		{
			if (!$user->hasPriviledge($priv)) {
				break;
			}
			foreach ($this->modules as $module)
			{
				$module instanceof Lamb_Module;
				if (in_array($command, $module->getTriggers($priv), true))
				{
					$module->onTrigger($server, $user, $from, $origin, $command, $message);
					return;
				}
			}
		}
				
		foreach (self::getPluginDirs() as $dir)
		{
			$priv = Lamb_User::longPriv(substr(basename($dir), 0, 1));
			if ( (!$is_admin) && (!$user->hasPriviledge($priv)) ) {
				continue;
			}
			
			$plugin_path = sprintf('%s/%s.php', $dir, $command);
			if (Common::isFile($plugin_path))
			{
				$bot = $this;
				require $plugin_path;
				return;
			}
		}
	}
	
	##############
	### Helper ###
	##############
	public function reply($message)
	{
		$this->lm_server->reply($this->lm_origin, $message);
	}
	
	/**
	 * Send a message to all channels on all servers.
	 * @param string $message
	 */
	public function superGlobalMessage($message)
	{
		foreach ($this->servers as $server)
		{
			$server instanceof Lamb_Server;
			$server->globalMessage($message);
		}
	}

	/**
	 * Send a message to the primary channel on every server.
	 * @param string $message
	 */
	public function globalMessage($message)
	{
		foreach ($this->servers as $server)
		{
			$server instanceof Lamb_Server;
			$channel = array_shift($server->getChannels());
			$server->reply($channel, $message);
		}
	}
}
?>