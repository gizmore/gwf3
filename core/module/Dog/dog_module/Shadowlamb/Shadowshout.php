<?php
final class Shadowshout
{
	const TEMP_KEY = 'SL_SHOUT';
	
	### Permissions for shout command.
	const MAX_LEVEL = 100;
	const MIN_LEVEL = 5;
	const MAX_DELAY = 600;
	const MIN_DELAY = 5;
	
	
	/**
	 * Send a message to all shadowlamb main channels.
	 * @param unknown_type $message
	 */
	public static function sendGlobalMessage($message)
	{
		foreach (Dog::getServers() as $server)
		{
			$server instanceof Dog_Server;
			self::sendServerMessage($server, $message);
		}
	}
	
	public static function sendServerMessage(Dog_Server $server, $message)
	{
		foreach ($server->getChannels() as $chan)
		{
			$chan instanceof Dog_Channel;
			if (!Dog_Conf_Mod_Chan::isModuleDisabled('Shadowlamb', $chan->getID()))
			{
				$chan->sendPRIVMSG($message);
			}
		}
	}
	
	/**
	 * Check if we may shout and do so.
	 * @param unknown_type $player
	 * @param unknown_type $message
	 */
	public static function shout(SR_Player $player, $message)
	{
		# check minlevel
		if ($player->getBase('level') < self::MIN_LEVEL)
		{
			# You need at least level %s to shout.
			$player->msg('1002', array(self::MIN_LEVEL));
			return false;
		}
		
		# check delay
		$delay = self::getShoutWait($player);
		if ($delay > 0)
		{
			# Please wait %s before you shout again.
			$player->msg('1044', array(GWF_Time::humanDuration($delay)));
			return false;
		}
		
		# store time
		$player->setTemp(self::TEMP_KEY, time());
		
		# send message (cannot get translated easily)
		$b = chr(2);
		self::sendGlobalMessage(sprintf('%s shouts: "%s"', $b.$player->getName().$b, $message));
	}
	
	private static function getShoutWait(SR_Player $player)
	{
		$range = self::MAX_DELAY - self::MIN_DELAY;
		$tpl = $range / self::MAX_LEVEL;
		$level = Common::clamp($player->getBase('level'), 0, self::MAX_LEVEL);
		$delay = self::MIN_DELAY + $tpl * (self::MAX_LEVEL-$level);
		$last = $player->hasTemp(self::TEMP_KEY) ? $player->getTemp(self::TEMP_KEY) : 0;
		$next = $last + $delay;
		return $next - time();
	}
	
	public static function onLocationGlobalMessage(SR_Player $player, $key, $args=NULL)
	{
		$server = Dog::getServer();
		$channel = Dog::getChannel();
		$sid = $server->getID();
//		$cid = $channel->getID();
		$party = $player->getParty();
		
//		$b = chr(2);
//		$message = sprintf('%s in %s: "%s".', $player->getName(), $party->getLocation(), $message);
		
		$sent = 0;
		foreach (Shadowrun4::getParties() as $pid => $p)
		{
			if ($party->sharesLocation($p))
			{
				foreach ($p->getMembers() as $m)
				{
					$m instanceof SR_Player;
					
					if ($m->isCreated())
					{
						if (false === ($u = $m->getUser()))
						{
							continue;
						}
						
						if (false === ($s = $u->getServer()))
						{
							continue;
						}
						
// 						$c = $s->getChannelByName('#shadowlamb');
						
// 						if ($sid === $s->getID())
// 						{
// 							if ( ($channel !== false) && ($channel->getUserByName($u->getName()) !== false) )
// 							{
// 								# TODO: fix this
// //								continue; # player already read it in irc.
// 							}
// 						}
						
						# send to player.
						$m->msg($key, $args);
// 						$m->message($message);
						$sent++;
					}
				}
			}
		}
		
//		if ($sent > 0)
//		{
//			$player->message(sprintf('%s players on cross servers read your message inside the same location. Use #exit or privmsg/query/pm with the bot.'));
//		}
	}
}
?>