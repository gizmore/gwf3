<?php
final class DOGMOD_Warfare extends Dog_Module
{
	const TIMEOUT = 1;
	
	private $auto_probe = true;
	private $dest = 'gizmore';
	private static $PORTS = array();
	private $to_scan_ip = array();
	private $to_scan_host = array();
	private $to_scan_user = array();
	private $curr_serv;
	private $curr_ip = '';
	private $curr_host = '';
	private $curr_user = '';
	private $curr_port = -1;
	private $status = 0;
	
	private $cache = array();
	private $report = array();
	
	################
	### Triggers ###
	################
	public function onInitServer(Dog_Server $server)
	{
//		echo __METHOD__.PHP_EOL;
		if (false === ($dir = glob('dog_module/Warfare/ports/*.php')))
		{
			Dog_Log::error('Warfare cannot read ports directory.');
			return false;
		}
		self::$PORTS = $dir;
	}

	public function onInstall()
	{
//		echo __METHOD__.PHP_EOL;
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge, $showHidden=true)
	{
		switch ($priviledge)
		{
			case 'admin': return array('probe', 'autoprobe', 'probe_out');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'probe' => 'Usage: %CMD% <host|ip>. Initiate a service discovery on a given host.',
			'autoprobe' => 'Usage: %CMD% <on|off>. Toggle the autoprobe mode. Off by default.',
			'probe_out' => 'Usage: %CMD% <channels,nicknames>. Set the probe output destinations. Default is echo to console!.',
		);
	}
	
	##############
	### Events ###
	##############
	public function onEvent(Lamb $bot, Dog_Server $server, $event, $from, $args)
	{
		if ($event === 'JOIN')
		{
			if (false !== ($user = $server->getUserFromOrigin($from, $args[0])))
			{
				if (false !== ($ip = $this->getIPfromOrigin($from)))
				{
					if ($this->auto_probe)
					{
						$this->addIP($server, $ip);
					}
					else
					{
						$this->output(sprintf('User %s has IP %s.', $user->getName(), $ip));
					}
				}
			}
		}
	}
	
	public function getIPfromOrigin($origin)
	{
		# freenode style 1:
		if (preg_match('/@.*(\\d{3})-(\\d{3})-(\\d{3})-(\\d{3})/', $origin, $matches))
		{
			return sprintf('%d.%d.%d.%d', intval($matches[1], 10), intval($matches[2], 10), intval($matches[3], 10), intval($matches[4], 10));
		}
		return false;
	}
	
	##############
	### Output ###
	##############
	public function output($message)
	{
		$have_out = false;
		$dest = preg_split('/(?: +|,)/', $this->dest);
		foreach ($dest as $d)
		{
			if ($this->curr_serv->getUser($d) === false && $this->curr_serv->getChannel($d) === false) {
				continue;
			}
			$this->curr_serv->sendPRIVMSG($d, $message);
			$have_out = true;
		}
		
		if (!$have_out)
		{
			echo "[*Warfare]: $msg\n";
		}
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Dog_Server $server, Dog_User $user, $from, $origin, $command, $message)
	{
		$out = '';
		switch ($command)
		{
			case 'probe'; $out = $this->onProbe($server, $user, $from, $origin, $message); break;
			case 'autoprobe': $out = $this->onAutoprobe($server, $user, $from, $origin, $message); break;
			case 'probe_out'; $out = $this->onProbechans($server, $user, $from, $origin, $message); break;
			default: return;
		}
		$server->reply($origin, $out);
	}
	
	public function onProbe(Dog_Server $server, Dog_User $user, $from, $origin, $message)
	{
		if (GWF_IP6::isValidV4($message)) {
			$ip = $message;
			$host = 'my.ip.com';
		}
		elseif ($message !== ($ip = gethostbyname($message))) {
			$host = $message;
		}
		else {
			return "Cannot resolve hostname $message.";
		}
		$this->addIP($server, $ip);
		return "Added $host / $ip  to the scanning queue (on IRC ".$server->getDomain().").";
	}
	
	private function addIP(Dog_Server $server, $ip, $host='localhost', $user='localhost')
	{
		$this->to_scan_ip[] = $ip;
		$this->to_scan_host[] = $host;
		$this->to_scan_user[] = $user;
		if ($this->status === 0)
		{
			$this->addTimer($server);
		}
	}
	
	private function addTimer(Dog_Server $server)
	{
//		echo "Added new timer.\n";
//		Lamb::instance()->addTimer($server, array($this, 'scanTimer'), NULL, self::TIMEOUT+rand(2,5));
		Lamb::instance()->addTimer(array($this, 'scanTimer'), self::TIMEOUT+rand(1,5), $server);
	}

	public function onAutoprobe(Dog_Server $server, Dog_User $user, $from, $origin, $message)
	{
		switch(strtolower($message))
		{
			case '1': case 'yes': case 'on':
				if (!$this->auto_probe) {
					$this->auto_probe = true;
					return "Autoprobe has been enabled.";
				} else {
					return "Autoprobe was already enabled.";
				}
			case '0': case 'no': case 'off':
				if ($this->auto_probe) {
					$this->auto_probe = false;
					return "Autoprobe has been disabled.";
				} else {
					return "Autoprobe was already disabled.";
				}
			default:
				return "Wrong option for autoprobe command."; 
		}
	}

	public function onProbechans(Dog_Server $server, Dog_User $user, $from, $origin, $message)
	{
		$this->dest = $message;
		return "Output will be redirected to $message.";
	}
	
	###############
	### Scanner ###
	###############
	public function scanTimer(Dog_Server $server, $args)
	{
		echo __METHOD__.PHP_EOL;
		switch ($this->status)
		{
			case 0: case 2: $this->onPopIP($server); break;
			case 1: $this->onNextPort($server); break;
			default: $this->onUnknownStatus($server); break;
		}
	}
	
	private function onPopIP(Dog_Server $server)
	{
		if (count($this->to_scan_ip) === 0) {
			$this->changeStatus(0);
			return;
		} 
		$this->changeStatus(1);
		$ip = array_pop($this->to_scan_ip);
		$host = array_pop($this->to_scan_host);
		$user = array_pop($this->to_scan_user);
		$username = is_string($user) ? $user : $user->getName();
		$this->curr_ip = $ip;
		$this->curr_user = $user;
		$this->curr_host = $host;
		$this->curr_port = -1;
		$this->curr_serv = $server;
		
		$this->output("onPopIP('$ip', '$username', '$host')");
		
		$this->onInit($server);
		$this->onNextPort($server);
	}
	
	private function getCurrUsername()
	{
		return is_string($this->curr_user) ? $this->curr_user : $this->curr_user->getName();
	}
	
	private function onNextPort(Dog_Server $server)
	{
		$this->curr_port++;
		if (count(self::$PORTS)==$this->curr_port) {
			$this->onJobDone();
		}
		else {
			$port = self::$PORTS[$this->curr_port];
			$this->discoverService($port);
		}
		$this->addTimer($server);
	}
	
	private function discoverService($port)
	{
		$portname = basename($port, '.php');
		$W = $this;
		$ip = $this->curr_ip;
		$host = $this->curr_host;
		$username = $this->getCurrUsername();
		Dog_Log::logDebug(sprintf('Probe %s (%s) [%s] on port %s', $host, $ip, $username, $portname));
		include $port;
	}
	
	private function onJobDone()
	{
		$this->changeStatus(2);
	}
	
	private function changeStatus($n)
	{
//		echo "Switch Warfare status to $n.\n";
		$this->status = $n;
	}
}
?>