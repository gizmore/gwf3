<?php
require_once 'Shadowrun4.php';

final class LambModule_Shadowlamb extends Lamb_Module
{
	const SR_SHORTCUT = '#';
	const WITH_INTERLINK = 0;
	
	# Hardcoded shadowlamb channels for shortcuts
	public static $INCLUDE_CHANS = array('#sr', '#shadowlamb');
	
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server) { Shadowrun4::init($server); }
	public function onInstall() { require_once 'SR_Install.php'; SR_Install::onInstall(false); }
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		# NO SPAM with it in other channels
		if ( ($server->getBotsNickname() !== $origin) && (!in_array($origin, self::$INCLUDE_CHANS, true)) ) {
			return;
		}
		
		# Trigger?
		if (Common::startsWith($message, self::SR_SHORTCUT)) {
			return Lamb::instance()->processMessageA($server, LAMB_TRIGGER.'sr '.substr($message, 1), $from);
		}
		
		if (false !== ($player = Shadowrun4::getPlayerByUID($user->getID())))
		{
			# Location glob
			if ($origin{0} === '#' && self::WITH_INTERLINK)
			{
				if ($player->isCreated())
				{
					if ($player->getParty()->getAction() === 'inside')
					{
						if (false === ($channel = $server->getChannel('#shadowlamb'))) {
							if (false === ($channel = $server->getChannel('#sr'))) {
								return;
							}
						}
						$this->onLocationGlobalMessage($server, $player, $channel, $message);
					}
				}
			}
		}
	}
	public function onTimer() { /*Shadowrun4::onTimer();*/ }
	
	
	private function onLocationGlobalMessage(Lamb_Server $server, SR_Player $player, Lamb_Channel $channel, $message)
	{
		$sid = $server->getID();
		$cid = $channel->getID();
		$party = $player->getParty();
		
		$message = sprintf('%s in %s: "%s".', $player->getName(), $party->getLocation(), $message);
		
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
						$u = $m->getUser();
						$s = $u->getServer();
						$c = $s->getChannel('#shadowlamb');
						
						if ($sid === $s->getID())
						{
							if ($channel->getUserByNameI($u->getName()))
							{
								continue; # player already read it in irc.
							}
						}
						
						# send to player.
						$m->message($message);
						$sent++;
					}
				}
			}
		}
		
		if ($sent > 0)
		{
			$player->message(sprintf('%s players on other servers read your message inside the same location. Use #exit or privmsg/query/pm with the bot.'));
		}
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('sr');
			default: return array();
		}
	}
	
	public function getHelp($trigger)
	{
		$help = array(
			'sr' => '%TRIGGER%sr <shadowrun command here>. Try '.self::SR_SHORTCUT.'help.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $channel_name, $command, $msg)
	{
		Shadowrun4::onTrigger($server, $user, $channel_name, $msg);
	}
	
}
?>