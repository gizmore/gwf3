<?php
require_once 'Lamb_ChannelPeak.php';
require_once 'Lamb_Greeting.php';
require_once 'Lamb_GreetMsg.php';
require_once 'Lamb_QuitJoin.php';
require_once 'Lamb_QuitJoinChannel.php';

/**
 * Greet the users. Also can store channel peak and QuitJoin records :]
 * @author gizmore
 */
final class LambModule_Greetings extends Lamb_Module
{
	###################
	### Lamb Module ###
	###################
	public function onInstall()
	{
		GDO::table('Lamb_ChannelPeak')->createTable();
		GDO::table('Lamb_Greeting')->createTable();
		GDO::table('Lamb_GreetMsg')->createTable();
		GDO::table('Lamb_QuitJoin')->createTable();
		GDO::table('Lamb_QuitJoinChannel')->createTable();
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
		if (Lamb_Greeting::hasBeenGreeted($user->getID(), $channel->getID()))
		{
			Lamb_Log::logDebug(sprintf('The user %s in channel %d(%s) has been greeted already.', $user->getName(), $channel->getID(), $channel->getName()));
			return;
		}
		
		if (false === ($greeting = Lamb_GreetMsg::getGreetMsg($server, $channel)))
		{
//			Lamb_Log::logError(sprintf('Could not find greet message for channel %d(%s).', $channel->getID(), $channel->getName()));
			return;
		}
		
		if ($greeting->isDisabled())
		{
			Lamb_Log::logDebug(sprintf('The greetings for channel %d(%s) are disabled.', $channel->getID(), $channel->getName()));
			return;
		}
		
		$message = $greeting->getVar('lgm_msg');
		
		switch ($greeting->getGreetMode())
		{
			case Lamb_GreetMsg::MODE_CHAN:
				$server->sendPrivmsg($channel->getName(), $user->getName().': '.$message);
				break;
			case Lamb_GreetMsg::MODE_NOTICE:
				$server->sendNotice($user->getName(), $message);
				break;
			case Lamb_GreetMsg::MODE_PRIVMSG:
				$server->sendPrivmsg($user->getName(), $message);
				break;
			default:
				Lamb_Log::logError('Invalid type of greeting in '.__FILE__.' line '.__LINE__.'!');
				return;
		}
		
		Lamb_Greeting::markGreeted($user->getID(), $channel->getID());
	}

	######################
	### Admin Triggers ###
	######################
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('quitjoin', 'peak');
			case 'staff': return array('+greet', '-greet', 'greetmode', '+peak', '-peak', '+quitjoin', '-quitjoin');
			case 'admin': return array('greet', 'greet_again');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'peak' => 'Usage: %CMD%. Show the maximum channel peak for this channel.',
			'+peak' => 'Usage: %CMD% [<channel>] [<server>]. Enable channel peak messages for a channel.',
			'-peak' => 'Usage: %CMD% [<channel>] [<server>]. Disable channel peak messages for a channel.',
		
			'quitjoin' => 'Usage: %CMD% [<username>]. Show the quitjoin record for this channel or an optional user.',
			'+quitjoin' => 'Usage: %CMD%. Enable the quitjoin fun messages for this channel.',
			'-quitjoin' => 'Usage: %CMD%. Disable the quitjoin fun messages for this channel.',

			'+greet' => 'Usage: %CMD% < the message >. Set and enable greet messages in the current channel.',
			'-greet' => 'Usage: %CMD%. Disable the greet messages in the current channel.',
			'greet' => 'Usage: %CMD%. Execute in a channel to show the channels greet message.',
			'greetmode' => 'Usage: %CMD% <channel|privmsg|notice>. Execute in a channel to set the greetings delivery mode. Default is channel.',
			'greet_again' => 'Usage: %CMD%. Execute in a channel to drop the delivered greetings for that channel.',
		);
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
			case 'greetmode'; $out = $this->onGreetMode($server, $user, $from, $origin, $message); break;
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
		
		if (false === ($channel = $bot->getCurrentChannel()))
		{
			return 'This command works in channels only.';
		}
		
		if (false === ($peak = Lamb_ChannelPeak::getPeak($channel->getID())))
		{
			return 'Database error!';
		}

		$date = $peak->getVar('lcpeak_date');
		$count = $peak->getVar('lcpeak_peak');
		$peakshow = $peak->isEnabled() ? 'enabled' : 'disabled';
		
		$count_now = $channel->getUserCount();
		if ($count_now > $count)
		{
			$peak->savePeak($count_now);
			$count = $count_now;
			$date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		}
		
		return sprintf('Channel peak of %d for %s has been reached on %s, %s ago. The peakshow is %s.', $count, $channel->getName(), GWF_Time::displayDate($date), GWF_Time::displayAge($date), $peakshow);
	}
	
	private function onPeakEnable(Lamb_Server $server, Lamb_User $user, $from, $origin, $message, $enable=true)
	{
		$bot = Lamb::instance();
		
		if (false === ($channel = $bot->getCurrentChannel()))
		{
			return 'This channel is unknown.';
		}
		
		if (false === ($peak = Lamb_ChannelPeak::getPeak($channel->getID())))
		{
			return 'Database error.';
		}
		
		if (false === $peak->saveOption(Lamb_ChannelPeak::ENABLED, $enable))
		{
			return 'Database error 2.';
		}
		
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
			return sprintf('The shortest join ever on %s in %s was from %s: %.02fs.', $server->getTLD(), $channel->getName(), $record->displayUser(), $record->displayTime());
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
		if (false === ($channel = Lamb::instance()->getCurrentChannel()))
		{
			return 'This command works in channel only.';
		}
		
		if (false === Lamb_GreetMSG::setGreetMsg($server, $channel, $message))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return sprintf('I have set the greet message to "%s" in channel %d(%s).', $message, $channel->getID(), $channel->getName());
	}
	
	private function onGreetDisable(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel()))
		{
			return 'This command works in channel only.';
		}
		
		if (false === ($msg = Lamb_GreetMSG::getGreetMsg($server, $channel)))
		{
			return 'Database error #1.';
		}
		
		if (false === $msg->setEnabled(false))
		{
			return 'Database error #2.';
		}
		
		return sprintf('The greeting message for channel %d (%s) has been disabled.', $channel->getID(), $channel->getName());
	}

	private function onGreetShow(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel()))
		{
			return 'This command works in channel only.';
		}

		if (false === ($msg = Lamb_GreetMsg::getGreetMsg($server, $channel)))
		{
			return sprintf('There is no greet message set for channel %d(%s).', $channel->getID(), $channel->getName());
		}
		
		$endis = $msg->isEnabled() ? 'and it is enabled' : 'but it is disabled';
		
		return sprintf('The greet message for %d(%s) is %s %s.', $channel->getID(), $channel->getName(), $msg->getVar('lgm_msg'), $endis);
	}
	
	private function onGreetMode(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		switch ($message)
		{
			case 'channel': case 'c':
			case 'notice': case 'n':
			case 'privmsg': case 'p':
			default: return $this->getHelpText('greetmode');
		}
	}
	
	private function onGreetDrop(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === ($channel = Lamb::instance()->getCurrentChannel()))
		{
			return 'This command works in channel only.';
		}
		
		$dropped = Lamb_Greeting::dropChannel($channel->getID());
		
		return sprintf('Ok, i have dropped %d delivered greetings. I will annoy them again!', $dropped);
	}
}
?>