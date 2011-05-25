<?php
require_once 'Lamb_ChannelPeak.php';
require_once 'Lamb_Greeting.php';
require_once 'Lamb_GreetMsg.php';
require_once 'Lamb_QuitJoin.php';
require_once 'Lamb_QuitJoinChannel.php';
/**
 * Greet the users. Also can store channel peak and QuitJoin Records :]
 * @author gizmore
 */
final class LambModule_Greetings extends Lamb_Module
{
	###################
	### Lamb Module ###
	###################
	public function onInstall()
	{
		GDO::table('Lamb_ChannelPeak')->createTable(true);
		GDO::table('Lamb_Greeting')->createTable(true);
		GDO::table('Lamb_GreetMsg')->createTable(true);
		GDO::table('Lamb_QuitJoin')->createTable(true);
		GDO::table('Lamb_QuitJoinChannel')->createTable(true);
	}
	
	public function onEvent(Lamb $bot, Lamb_Server $server, $event, $from, $args)
	{
		if (false === ($channel = $bot->getCurrentChannel())) {
			return;
		}
		if (false === ($user = $bot->getCurrentUser())) {
			return;
		}
		
		switch ($event)
		{
			case 'JOIN':
				Lamb_QuitJoin::onJoin($bot, $server, $channel, $user);
				Lamb_ChannelPeak::onJoin($bot, $server, $channel, $user);
				break;
				
			case 'PART':
			case 'QUIT':
				Lamb_QuitJoin::onQuit($bot, $server, $channel, $user);
				break;
		}
	}

	####################
	### Greet Engine ###
	####################
	public function onJoin(Lamb_Server $server, Lamb_User $user, Lamb_Channel $channel)
	{
		$cid = $channel->getID();
		if (false === ($greeting = GDO::table('Lamb_GreetMsg')->selectFirstObject('*', "lgm_cid=$cid AND lgm_options&1"))) {
			return;
		}
		if (Lamb_Greeting::hasBeenGreeted($user->getID(), $channel->getID())) {
			return;
		}
		
		$message = $greeting->getVar('lgm_msg');
		
		switch ($greeting->getMode())
		{
			case self::CHANNEL:
				$server->sendPrivmsg($channel->getName(), $user->getName().': '.$message);
				break;
			case self::NOTICE:
				$server->sendNotice($user->getName(), $message);
				break;
			case self::PRIVMSG:
				$server->sendPrivmsg($user->getName(), $message);
				break;
			default:
				Lamb_Log::log('Invalid type of greeting in '.__FILE__.' line '.__LINE__.'!');
				return;
		}
		
		Lamb_Greeting::markGreeted($user->getID(), $channel->getID());
	}
	
//	private function loadMessage(Lamb_Server $server, Lamb_Channel $channel)
//	{
//		if (false === ($msg = GWF_Settings::getSetting('LMB_CHN_'.$channel->getID()))) {
//			return false;
//		}
//		
//		require LAMB::DIR.'lamb_module/Greetings/greetings_conf.php';
//		foreach ($greet_conf as $conf_server => $conf)
//		{
//			if (strpos($server->getName(), $conf_server) !== false)
//			{ 
//				foreach ($conf as $conf_channel => $message)
//				{
//					if ($conf_channel === $channel->getName())
//					{
//						return array($greet_mode, $message);
//					}
//				}
//			}
//		}
//		return false;
//	}

	######################
	### Admin Triggers ###
	######################
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('quitjoin', 'peak');
			case 'staff': return array('+quitjoin', '-quitjoin', '+peak', '-peak');
			case 'admin': return array('+greet', '-greet', 'greet', 'greetmode', 'greet_again');
			default: return array();
		}
	}
	public function getHelp($trigger)
	{
		$help = array(
			'peak' => 'Usage: %TRIGGER%peak. Show the maximum channel peak for this channel.',
			'+peak' => 'Usage: %TRIGGER%+peak [<channel>] [<server>]. Enable channel peak messages for a channel.',
			'-peak' => 'Usage: %TRIGGER%-peak [<channel>] [<server>]. Disable channel peak messages for a channel.',
		
			'quitjoin' => 'Usage: %TRIGGER%quitjoin [<username>]. Show the quitjoin record for this channel or an optional user.',
			'+quitjoin' => 'Usage: %TRIGGER%+quitjoin. Enable the quitjoin fun messages for this channel.',
			'-quitjoin' => 'Usage: %TRIGGER%-quitjoin. Disable the quitjoin fun messages for this channel.',

			'+greet' => 'Usage: %TRIGGER%+greet < the message >. Set and enable greet messages in the current channel.',
			'-greet' => 'Usage: %TRIGGER%-greet. Disable the greet messages in the current channel.',
			'greet' => 'Usage: %TRIGGER%greet. Execute in a channel to show the channels greet message.',
			'greet_mode' => 'Usage: %TRIGGER%greetmode <privmsg|channel|notice>. Execute in a channel to set the greetings delivery mode.',
			'greet_again' => 'Usage: %TRIGGER%greet_again. Execute in a channel to drop the delivered greetings for that channel.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		$out = '';
		switch ($command)
		{
			case 'peak': $out = $this->onPeak($server, $user, $from, $origin, $message); break;
			case '+peak': $out = $this->onPeakEnable($server, $user, $from, $origin, $message, true); break;
			case '-peak': $out = $this->onPeakEnable($server, $user, $from, $origin, $message, false); break;
			
			case 'quitjoin': $out = $this->onQuitJoin($server, $user, $from, $origin, $message); break;
			case '+quitjoin': $out = $this->onQuitJoinEnable($server, $user, $from, $origin, $message, true); break;
			case '-quitjoin': $out = $this->onQuitJoinEnable($server, $user, $from, $origin, $message, false); break;
			
			case '+greet': $out = $this->onGreetSet($server, $user, $from, $origin, $message); break;
			case '-greet': $out = $this->onGreetDisable($server, $user, $from, $origin, $message); break;
			case 'greet'; $out = $this->onGreetShow($server, $user, $from, $origin, $message); break;
			case 'greet_mode'; $out = $this->onGreetMode($server, $user, $from, $origin, $message); break;
			case 'greet_again'; $out = $this->onGreetDrop($server, $user, $from, $origin, $message); break;
			
			default: return;
		}
		$server->reply($origin, $out);
	}
	
	############
	### Peak ###
	############
	private function onPeak(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$bot = Lamb::instance();
		if (false === ($channel = $bot->getCurrentChannel())) {
			return 'This command works in channels only.';
		}
		if (false === ($peak = Lamb_ChannelPeak::getPeak($channel))) {
			return 'There is no channel peak set for this channel.';
		}
		$count = $peak->getVar('lcpeak_peak');
		$date = $peak->getVar('lcpeak_date');
		
		$count_now = $channel->getUserCount();
		if ($count_now > $count)
		{
			$count = $count_now;
			$date = GWF_Time::getDate(GWF_Time::LEN_SECOND);
			$peak->saveVar('lcpeak_peak', $count);
		}
		
		$peakshow = $peak->isEnabled() ? 'enabled' : 'disabled';
		return sprintf('Channel peak of %d for %s has been reached on %s, %s ago. The peakshow is %s.', $count, $channel->getName(), GWF_Time::displayDate($date), GWF_Time::displayAge($date), $peakshow);
	}
	
	private function onPeakEnable(Lamb_Server $server, Lamb_User $user, $from, $origin, $message, $enable=true)
	{
		$bot = Lamb::instance();
		if (false === ($channel = $bot->getCurrentChannel())) {
			return $bot->reply('This channel is unknown.');
		}
		
		if (false === ($peak = Lamb_ChannelPeak::getPeak($channel->getID()))) {
			return $bot->reply('Database error.');
		}
		
		$peak->saveOption(Lamb_ChannelPeak::ENABLED, $enable);
		
		$cname = $channel->getName();
		$bool = $enable ? 'enabled' : 'disabled';
		return "The peakshow for {$cname} has been {$bool}.";
	}
	
	private function onQuitJoin(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$bot = Lamb::instance();
		if (false === ($channel = $bot->getCurrentChannel())) {
			if (false === ($record = Lamb_QuitJoinChannel::getGlobalRecord())) {
				return 'I do not have any quitjoin records yet.';
			} else {
				return sprintf('The shortest join ever was from %s in %s on %s: %.02fs.', $record->displayUser(), $record->displayChannel(), $record->displayServer(), $record->displayTime());
			}
		}
		
		if (false === ($record = Lamb_QuitJoinChannel::getChannelRecord($channel))) {
			return 'I do not have any quitjoin records for the '.$channel->getName().' channel yet.';
		} else {
			return sprintf('The shortest join ever on %s in %s was from %s: %.02fs.', $server->getName(), $channel->getName(), $record->displayUser(), $record->displayTime());
		}
	}
	
	private function onQuitJoinEnable(Lamb_Server $server, Lamb_User $user, $from, $origin, $message, $enable=true)
	{
		$bot = Lamb::instance();
		if (false === ($channel = $bot->getCurrentChannel())) {
			return 'You have to exec this in the channel.';
		}
		
		if (false === ($row = Lamb_QuitJoinChannel::getOrCreateRow($channel))) {
			return 'Database error.';
		}
		
		$row->saveOption(Lamb_QuitJoinChannel::ENABLED, $enable);
		
		$cn = $channel->getName();
		$en = $enable ? 'enabled' : 'disabled';
		return "The quitjoin records for {$cn} have been {$en}.";
	}

	private function onGreetSet(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel())) {
			return 'This command works in channel only.';
		}
		if (false === Lamb_GreetMSG::setGreeting($server, $channel, $message)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		return sprintf('I have set the greet message to "%s" in %s.', $message, $channel->getName());
	}
	
	private function onGreetDisable(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel())) {
			return 'This command works in channel only.';
		}
	}
	
	private function onGreetShow(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel())) {
			return 'This command works in channel only.';
		}

		if (false === ($msg = Lamb_GreetMsg::getGreetMsg($server, $channel))) {
			return 'There is no greet message set.';
		}
	}
	
	private function onGreetMode(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		var_dump($message);
	}
	
	private function onGreetDrop(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel())) {
			return 'This command works in channel only.';
		}
		$dropped = Lamb_Greeting::dropChannel($channel->getID());
		return sprintf('Ok, i have dropped %d delivered greetings. I will annoy them again!', $dropped);
	}
}
?>