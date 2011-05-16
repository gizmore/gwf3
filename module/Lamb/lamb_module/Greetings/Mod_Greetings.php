<?php
require_once 'Lamb_Greeting.php';
final class LambModule_Greetings extends Lamb_Module
{
	const NOTICE = 1;
	const PRIVMSG = 2;
	const CHANNEL = 3;
	
	###################
	### Lamb Module ###
	###################
	public function onInstall() { GDO::table('Lamb_Greeting')->createTable(false); }

	####################
	### Greet Engine ###
	####################
	public function onJoin(Lamb_Server $server, Lamb_User $user, $from, $origin)
	{
		if ($user->getName() === $server->getBotsNickname()) {
			return;
		}
		
		if (false === ($channel = Lamb_Channel::getByName($server, $origin))) {
			Lamb_Log::log('Unknown channel in onJoin Mod_Greeting: '.$origin);
			return;
		}
		
		if (false === ($message = $this->loadMessage($server, $channel))) {
			return;
		}
		
		
		if (Lamb_Greeting::hasBeenGreeted($user->getID(), $channel->getID())) {
			return;
		}
		
		switch ($message[0])
		{
			case self::CHANNEL:
				$server->sendPrivmsg($channel->getName(), $user->getName().': '.$message[1]);
				break;
			case self::NOTICE:
				$server->sendNotice($user->getName(), $message[1]);
				break;
			case self::PRIVMSG:
				$server->sendPrivmsg($user->getName(), $message[1]);
				break;
			default:
				Lamb_Log::log('Invalid type of greeting in '.__FILE__.' line '.__LINE__.'!');
				return;
		}
		
		Lamb_Greeting::markGreeted($user->getID(), $channel->getID());
	}
	
	private function loadMessage(Lamb_Server $server, Lamb_Channel $channel)
	{
		require LAMB::DIR.'lamb_module/Greetings/greetings_conf.php';
		foreach ($greet_conf as $conf_server => $conf)
		{
			if (strpos($server->getName(), $conf_server) !== false)
			{ 
				foreach ($conf as $conf_channel => $message)
				{
					if ($conf_channel === $channel->getName())
					{
						return array($greet_mode, $message);
					}
				}
			}
		}
		return false;
	}

	######################
	### Admin Triggers ###
	######################
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'admin': return array('drop_greetings');
			default: return array();
		}
	}
	public function getHelp($trigger)
	{
		$help = array(
			'drop_greetings' => 'Usage: %TRIGGER%drop_greetings. Execute in a channel to drop the delivered greetings for that channel.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		$out = '';
		switch ($command)
		{
			case 'drop_greetings'; $out = $this->onDropGreetings($server, $user, $from, $origin, $message); break;
			default: return;
		}
		$server->reply($origin, $out);
	}
	
	private function onDropGreetings(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb_Channel::getByName($server, $origin))) {
			Lamb_Log::log('Unknown channel: '.$origin);
			return;
		}
		
		$dropped = Lamb_Greeting::dropChannel($channel->getID());
		return sprintf('Ok, i have dropped %d delivered greetings. I will annoy them again!', $dropped);
	}
	
	
}
?>