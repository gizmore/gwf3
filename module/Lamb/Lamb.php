<?php
/**
 * The precious Lamb bot.
 * @author gizmore
 * @version 3.01
 */
final class Lamb
{
	#############
	### Const ###
	#############
	const DIR = 'module/Lamb/';
	
	################
	### Instance ###
	################
	private static $instance = NULL;
	/**
	 * Get the bot instance.
	 * @return Lamb
	 */
	public static function instance() { return self::$instance; } 
	public function __construct() { self::$instance = $this; }
	
	############
	### Vars ###
	############
	private $online = false; # All servers up?
	private $running = true; # Running?
	private $is_idle = true; # No message on none of the servers?
	/**
	 * LastMessage_Server
	 * @var Lamb_Server
	 */
	private $lm_server = NULL; # Current server
	private $lm_origin = '';   # Current origin
	/**
	 * Active timers.
	 * @var array(Lamb_Timer)
	 */
	private $timers = array();
	/**
	 * Loaded modules.
	 * @var array('Modulename' => Lamb_Module)
	 */
	private $modules = array();
	/**
	 * Servers in memory.
	 * @var array(serverid => Lamb_Server)
	 */
	private $servers = array();

	##############
	### Getter ###
	##############
	public function getModules() { return $this->modules; }
	public function getServers() { return $this->servers; }

	###############
	### Current ###
	###############
	/**
	 * Get the server where the current message came from.
	 * @return Lamb_Server
	 */
	public function getCurrentServer()
	{
		return $this->lm_server;
	}
	/**
	 * Get the current channel where the current message came from.
	 * @see getCurrentOrigin()
	 * @return Lamb_Channel|false
	 */
	public function getCurrentChannel()
	{
		return $this->lm_server->getChannel($this->lm_origin);
	}
	/**
	 * Get origin where the current message occured.
	 * @return string
	 */
	public function getCurrentOrigin()
	{
		return $this->lm_origin;
	}
	/**
	 * Get the current user where the message came from.
	 * @return Lamb_User
	 */
	public function getCurrentUser()
	{
		return $this->lm_server->getUser($this->lm_server->getFrom());
	}
	
	##############
	### Uptime ###
	##############
	private function sumUptime()
	{
		$total = GWF_Settings::getSetting('_lamb3_uptime');
		$total += GWF_Settings::getSetting('_lamb3_shutdowntime') - GWF_Settings::getSetting('_lamb3_startuptime');
		GWF_Settings::setSetting('_lamb3_uptime', $total);
	}
	
	############
	### Init ###
	############
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
			if ($host !== '')
			{
				$server = Lamb_Server::factory($host, $nicks[$i], $passs[$i], $chans[$i], $admin[$i]);
				
				if (false !== $server->replace())
				{
					if (false !== $server->saveConfigVars($host, $nicks[$i], $chans[$i], $passs[$i], $admin[$i]))
					{
						$this->addServer($server);
					}
				}
			}
		}
		
		
		Lamb_Log::logDebug('Checking servers on connectivity ...');
		$up = 0;
		foreach ($this->servers as $server)
		{
			$server instanceof Lamb_Server;
			Lamb_Log::logDebug(sprintf('Checking server %s-%s', $server->getID(), $server->getHost()));
			if ($server->setupIP())
			{
				$up++;
			} 
		}
		
		Lamb_Log::logDebug(sprintf('%s of %s are up.', $up, count($this->servers)));
		
		if ($up === 0)
		{
			return Lamb_Log::logError("Please add some working servers to the config.");
		}
		
		# Autodetect blocking I/O.
//		define('LAMB_BLOCKING_IO', count($this->servers)<2);
		define('LAMB_BLOCKING_IO', 0);
		
		# Init 
		return $this->initModules();
	}
	
	public function initServer(Lamb_Server $server)
	{
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->initServer($server);
		}
	}
	
	private function initModules()
	{
//		Lamb_Log::logDebug(__METHOD__);
		$result = true;
		foreach (explode(';', LAMB_MODULES) as $module_name)
		{
			if (false === $this->initModule($module_name))
			{
				$result = false;
			}
		}
		return $result;
	}
	
	private function initModule($module_name)
	{
		Lamb_Log::logDebug(sprintf('Lamb::initModule(%s)', $module_name));
		# Include
		$module_dir = self::DIR.sprintf('lamb_module/%s', $module_name);
		if (!Common::isDir($module_dir))
		{
			return Lamb_Log::logError(sprintf('Lamb::initModule(%s) failed. Directory "%s" not found.', $module_name, $module_dir).PHP_EOL);
		}
		$module_file = self::DIR.sprintf('lamb_module/%s/Mod_%s.php', $module_name, $module_name);
		if (!Common::isFile($module_file))
		{
			return Lamb_Log::logError(sprintf('Lamb::initModule(%s) failed: File "%s" not found.', $module_name, $module_file).PHP_EOL);
		}
		require_once $module_file;
		$classname = sprintf('LambModule_%s', $module_name);
		if (!class_exists($classname))
		{
			return Lamb_Log::logError(sprintf('Lamb::initModule(%s) failed: Class "%s" not found.', $module_name, $classname).PHP_EOL);
		}
		
		# Create
		$module = new $classname();
		$module instanceof Lamb_Module;
		$module->setName($module_name);

		# Install
		if (false === ($module->onInstall()))
		{
			return false;
		}
		
		#Init
		if (false === ($module->onInit()))
		{
			return false;
		}

		# Cache
		$this->modules[] = $module;
		
		return true;
	}
	
	private function initTimers()
	{
		# Modules
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onInitTimers();
		}
		
		# One timer for all server.
		$dir = self::DIR.'lamb_timer/all_servers_one';
		foreach ($this->getServers() as $server)
		{
			$server instanceof Lamb_Server;
			GWF_File::filewalker($dir, true, array($this, 'initTimersDir'), false, $server);
		}

		# One timer per server for all servers.
		$dir = self::DIR.'lamb_timer/all_servers_all';
		GWF_File::filewalker($dir, true, array($this, 'initTimersDir'), false, $server);
		
		# One timer per server for a single server.
		$dir = self::DIR.'lamb_timer/one_server_one';
		GWF_File::filewalker($dir, true, array($this, 'initTimersDirServer'), false, NULL);
	}
	
	public function initTimersDirServer($entry, $fullpath, $null=NULL)
	{
		if (false !== ($serverid = Lamb_Server::getIDByHost($entry)))
		{
			if (false !== ($server = $this->getServer($serverid)))
			{
				GWF_File::filewalker($fullpath, true, array($this, 'initTimersDir'), false, $server);
			}
			else
			{
				Lamb_Log::logDebug(sprintf("Server %d-%s for Timer in path \"%s\" is not Online.", $serverid, $entry, $fullpath));
			}
		}
		else
		{
			Lamb_Log::logError(sprintf('Timer in path "%s" could not find it\'s server: %s.', $fullpath, $entry));
		}
	}
	
	public function initTimersDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath.'/infinity', true, array($this, 'initTimerInfDir'), false, $server);
		GWF_File::filewalker($fullpath.'/triggered', true, array($this, 'initTimerTrigDir'), false, $server);
	}
	
	public function initTimerInfDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath, array($this, 'initTimerInf'), true, true, array($server, $entry));
	}
	
	public function initTimerInf($entry, $fullpath, $data)
	{
		list($server, $seconds) = $data;
		$this->addTimer(array($this, 'executeTimerPlugin'), $seconds, $server, array($fullpath));
	}

	public function initTimerTrigDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath, true, array($this, 'initTimerTrigDirRep'), false, array($server, $entry));
	}
	
	public function initTimerTrigDirRep($entry, $fullpath, $data)
	{
		$data[] = $entry;
		GWF_File::filewalker($fullpath, array($this, 'initTimerTrig'), true, true, $data);
	}
	
	public function initTimerTrig($entry, $fullpath, $data)
	{
		list($server, $repeat, $seconds) = $data;
		$this->addTimer(array($this, 'executeTimerPlugin'), $seconds, $server, array($fullpath), $repeat);
	}
	
	/**
	 * Execute a timer plugin.
	 * @param Lamb_Server $server
	 * @param array $args
	 */
	public function executeTimerPlugin($server, array $args)
	{
		list($fullpath) = $args;
		if (!Common::isFile($fullpath))
		{
			return Lamb_Log::logError(sprintf('Can not execute timer: "%s".', $fullpath));
		}
		
		$bot = $this;
		unset($args);
		include $fullpath;
		return true;
	}
	
	################
	### Mainloop ###
	################
	/**
	 * Mainloop, Y U NO RETURN?!
	 */
	public function mainloop()
	{
		while ($this->running)
		{
			$this->is_idle = true;
			
			foreach ($this->servers as $serverid => $server)
			{
				$this->lm_server = $server;
				$this->processServer($server);
			}
			
			if ($this->checkOnline())
			{
				$this->processTimers();
			}
			
//			$this->processSTDIN();
			
			if ($this->is_idle)
			{
				usleep(LAMB_SLEEP_MILLIS * 1000);
			}
		}
	}
	
	/**
	 * Check if the bot is online everywhere.
	 * If so we cache that, because single servers may go down while online.
	 * @return true|false
	 */
	private function checkOnline()
	{
		# Cached?
		if ($this->online === true)
		{
			return true;
		}
		
		$up = 0;
		$need = count($this->servers);
		
		foreach ($this->servers as $server)
		{
			$server instanceof Lamb_Server;
			if ($server->isOnline())
			{
				$up++;
			}
		}
		
		if ($up < $need)
		{
			return false;
		}
		
		# 1st time online ...
		$this->online = true;
		$this->addTimer(array($this, 'onOnline'), 5.0, NULL, NULL, Lamb_Timer::REPEAT_NO);
		
		return false;
	}
	
	/**
	 * All servers connected. Now we launch the timers.
	 */
	public function onOnline()
	{
		Lamb_Log::logDebug(__METHOD__);
		
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onOnline();
		}
		
		return $this->initTimers();
	}
	
	#############
	### STDIN ###
	#############
	/**
	 * Process input from STDIN.
	 * Does not seem to work :(
	 */
//	private function processSTDIN()
//	{
//		$line = fscanf(STDIN, "%s".PHP_EOL);
//		$line = trim($line[0]);
//		if (!preg_match('/[ a-z_0-9]/i', $line)) {
//			return;
//		}
//		echo "Haha! You said $line!\n";
//	}
	
	##############
	### Timers ###
	##############
	/**
	 * Add a new timer to Lamb.
	 * @see Lamb_Timer
	 * @param mixed $callback Callbacks
	 * @param float $seconds Delay in seconds 
	 * @param Lamb_Server|NULL $server Optional server arg
	 * @param array|NULL $args Optional callback args
	 * @param int $repeat Number of repeats
	 * @param int $delay Optional initial delay in seconds
	 */
	public function addTimer($callback, $seconds=1.0, $server=NULL, $args=NULL, $repeat=Lamb_Timer::REPEAT_INF, $delay=Lamb_Timer::DELAY_DISABLE)
	{
		Lamb_Log::logDebug(sprintf('Adding new timer: "%s" in %.02f with repeat %d.', GWF_Hook::callbackToName($callback), $seconds, $repeat));
		$this->timers[] = new Lamb_Timer($callback, $seconds, $server, $args, $repeat, $delay);
	}
	
	private function processTimers()
	{
		$t = microtime(true);
		foreach ($this->timers as $i => $timer)
		{
			$timer instanceof Lamb_Timer;
			if ($timer->execute($t))
			{
				unset($this->timers[$i]);
				Lamb_Log::logDebug('A Lamb_Timer got removed.');
			}
		}
	}
	
	public function flushTimers()
	{
		$this->timers = array();
		return $this->initTimers();
	}
	
//	public function processTimerPlugins(Lamb_Server $server, $args)
//	{
//		# Store uptime is a basic timer
//		GWF_Settings::setSetting('_lamb3_shutdowntime', microtime(true));
//		
//		$path = self::DIR.'lamb_timer';
//		if (false !== ($dir = dir($path)))
//		{
//			while (false !== ($entry = $dir->read()))
//			{
//				if (Common::endsWith($entry, '.php'))
//				{
//					include "$path/$entry";
//				}
//			}
//			$dir->close();
//		}
//		else {
//			echo "Cannot read timers dir!\n";
//		}
//		
//		foreach ($this->modules as $module)
//		{
//			$module->onTimer($server);
//		}
//		
//		// Add timer again
//		$this->addTimer($server, array($this, 'processTimerPlugins'), NULL, LAMB_TIMER_INTERVAL);
//	}
	
	###############
	### Process ###
	###############
	private function processServer(Lamb_Server $server)
	{
		$c = $server->getConnection();
		if ($c->isConnected())
		{
			while (true)
			{
				$server->getConnection()->sendQueue();
				
//				if ( ($msg === false) || ($msg === '') ) 
				if ('' === ($msg = trim($c->getMessage())))
				{
					return true;
				}
				
				$this->is_idle = false;
				$this->processMessage($server, $msg);
			}
		}
		
		elseif (false === $server->connect())
		{
			$this->removeServer($server);
			return false;
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
//		if ('' === ($message = trim($message)))
//		{
//			return true;
//		}
		
		if ($server->isLogging())
		{
			Lamb_Log::logChat($server, $message);
		}
		elseif (LAMB_DEV)
		{
			echo $message.PHP_EOL;
		}
		
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
			if ($arg{0} === ':')
			{
				# implode everything after :
				$args[] = trim(substr($arg, 1).' '.implode(' ', $by_space));
				break;
			}
			else
			{
				# Normal arg
				$args[] = $arg;
			}
		}
		
		# Cache
		$server->setFrom($from);
		$this->lm_server = $server;
		$this->lm_origin = $args[0];
		
		# Process
		return $this->processCommand($server, $command, $from, $args);
		
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
	}
	
	
	private function processCommand(Lamb_Server $server, $command, $from, array $args)
	{
		# Anti ownage. (thx noother)
		if (strpos($command, '..') !== false)
		{
			return Lamb_Log::logError("Rouge IRCD: {$command}");
		}
		
		$event_filename = self::DIR.sprintf('lamb_event/%s.php', $command);
		if (Common::isFile($event_filename))
		{
			# Include event
			$bot = $this;
			
			include $event_filename;
			
			# Execute module events
			foreach ($this->modules as $module)
			{
				$module->onEvent($bot, $server, $command, $from, $args);
			}
			
			# Execute plugin events (001, PRIVMSG, etc)
			if (LAMB_EVENT_PLUGINS)
			{
				$plugdir = self::DIR.sprintf('lamb_event_plugin/%s', $command);
				if (Common::isDir($plugdir))
				{
					$this->processEventPlugins($plugdir, $server, $command, $from, $args);
				}
			}
			
			# All fine probably.
			return true;
		}
		else
		{
			echo "=== UNKNOWN  EVENT ===".PHP_EOL;
			Lamb_Log::debugCommand($server, $command, $from, $args);
			return Lamb_Log::logError(sprintf('Unknown event: %s', $command));
		}
	}
	
	private function processEventPlugins($plugdir, Lamb_Server $server, $command, $from, array $args)
	{
		GWF_File::filewalker($plugdir, array($this, 'processEventPlugin'), true, true, array($server, $command, $from, $args));
	}

	public function processEventPlugin($entry, $fullpath, $data)
	{
		$bot = $this;
		list($server, $command, $from, $args) = $data;
		unset($data);
		unset($entry);
		include $fullpath;
	}
	
	###############
	### Servers ###
	###############
	/**
	 * Disconnect and remove a server. Return true if a server got removed or false.
	 * @param Lamb_Server $server
	 * @return true|false
	 */
	public function removeServer(Lamb_Server $server)
	{
		$sid = $server->getID();
		# Not there?
		if (!isset($this->servers[$sid]))
		{
			return false;
		}
		# Remove
		unset($this->servers[$i]);
		$server->disconnect('Server removed unexpectedly?');
		$this->running = count($this->servers) > 0;
		Lamb_Log::logDebug(sprintf('Server %s-%s got removed.', $server->getID(), $server->getHostname()));
		return true;
	}
	
	/**
	 * Add a server to lamb. It will connect in the mainloop then. Return false if server is already added or true;
	 * Enter description here ...
	 * @param Lamb_Server $server
	 */
	public function addServer(Lamb_Server $server)
	{
		# Duplicate?
		$sid = $server->getID();
		if (isset($this->servers[$sid]))
		{
			return false;
		}
		# Add
		$this->servers[$sid] = $server;
		return true;
	}
	
	/**
	 * Get a server by id.
	 * @param int $serverid
	 * @return Lamb_Server
	 */
	public function getServer($serverid)
	{
		$id = (int)$serverid;
		return isset($this->servers[$id]) ? $this->servers[$id] : false;
	}
	
	###############
	### PRIVMSG ###
	###############
	/**
	 * A privmsg occured.
	 * @param Lamb_Server $server
	 * @param string $from
	 * @param string $origin
	 * @param string $message
	 * @return true|false
	 */
	public function onPrivmsg(Lamb_Server $server, $from, $origin, $message)
	{
		if (false === ($user = $server->getUserFromOrigin($from, $origin)))
		{
			Lamb_Log::logError(sprintf('Cannot getUserFromOrigin(%s, %s) onPrivmsg on server %s.', $from, $origin, $server->getHostname()));
			return;
		}
		
		$user->saveVars(array(
			'lusr_last_channel' => $origin,
			'lusr_last_message' => $message,
			'lusr_timestamp' => time(),
		));
		
		$message = preg_replace('/[ ]{2,}/', ' ', $message);
		
		$x01 = "\x01";
		if ( (Common::startsWith($message, $x01)) && (Common::endsWith($message, $x01)) )
		{
			return $this->onCTCP($server, $user, $from, $origin, substr($message, 1, -1));
		}
		else
		{
			return $this->onPrivmsgModules($server, $user, $from, $origin, $message);
		}
	}
	
	/**
	 * A CTCP message got received.
	 * @param Lamb_Server $server
	 * @param Lamb_User $user
	 * @param string $from
	 * @param string $origin
	 * @param string $message
	 */
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
				return $server->sendCTCPReply($user->getName(), sprintf('VERSION Lamb v%s. http://lamb.gizmore.org', LAMB_VERSION));
		}
		
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onCTPC($server, $user, $from, $origin, $message);
		}
		
		return true;
	}
	
	private function onPrivmsgModules(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		foreach ($this->modules as $module)
		{
			$module instanceof Lamb_Module;
			$module->onPrivmsg($server, $user, $from, $origin, $message);
		}
	}
	
	###############
	### Plugins ###
	###############
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

	/**
	 * A privmsg with %TRIGGER% has occured.
	 * @param Lamb_Server $server
	 * @param string $from
	 * @param string $origin
	 * @param string $message
	 */
	public function onTrigger(Lamb_Server $server, $from, $origin, $message)
	{
		if ( (false === ($user = $server->getUserFromOrigin($from))) && (false === ($user = $server->getUserByNickname($from))) )
		{
			return Lamb_Log::logError(sprintf('In %s(%s, %s, %s, %s): getUserFromOrigin(%s) failed!', __METHOD__, $server->getHostname(), $from, $origin, $message, $from));
		}
		
		$is_admin = $user->isLoggedIn() && $server->isAdminUsername($user->getName());
		
		if (!$is_admin)
		{
			if (false !== ($channel = $server->getChannel($origin)))
			{
				if (!$channel->allowsTrigger())
				{
					return false;
				}
			}
		}
		
//		$this->lm_origin = $origin;
		
		$message = preg_replace('/[ ]{2,}/', ' ', $message);
		$message = ltrim($message, LAMB_TRIGGER);
		
		if ( ($message === '') || ($message{0} === '/') )
		{
			return;
		}
		
		$command = Common::substrUntil($message, ' ');
		$message = Common::substrFrom($message, ' ', '');
		
		# Module trigger
		foreach (Lamb_User::$PRIVS as $priv)
		{
			if (!$user->hasPriviledge($priv))
			{
				break;
			}
			
			foreach ($this->modules as $module)
			{
				$module instanceof Lamb_Module;
				if (in_array($command, $module->getTriggers($priv), true))
				{
					return $module->onTrigger($server, $user, $from, $origin, $command, $message);
				}
			}
		}

		# Plugin trigger
		foreach (self::getPluginDirs() as $dir)
		{
			$priv = Lamb_User::longPriv(substr(basename($dir), 0, 1));
			if ( (!$is_admin) && (!$user->hasPriviledge($priv)) )
			{
				continue;
			}
			
			$plugin_path = sprintf('%s/%s.php', $dir, $command);
			if (Common::isFile($plugin_path))
			{
				$bot = $this;
				require $plugin_path;
				return true;
			}
		}
		
		# Unknown command
		return false;
	}
	
	##############
	### Helper ###
	##############
	/**
	 * get help for a command via the help plugin.
	 * @param string $cmd
	 * @return string
	 */
	public function getHelp($cmd)
	{
		return $this->processMessageA($this->lm_server, LAMB_TRIGGER.'help '.$cmd, $this->lm_server->getFrom());
	}
	
	/**
	 * Reply to the current origin and user.
	 * @param string $message
	 * @return true|false
	 */
	public function reply($message)
	{
		return $this->lm_server->reply($this->lm_origin, $message);
	}
}
?>
