<?php
require_once 'Shadowrun4.php';

final class LambModule_Shadowlamb extends Lamb_Module
{
//	const WITH_INTERLINK = 0;
	
	# Hardcoded shadowlamb channels for shortcuts
	public static $INCLUDE_CHANS = array('#sr', '#shadowlamb');
	
	################
	### Triggers ###
	################
	public function onInstall() { Shadowrun4::init(); require_once 'SR_Install.php'; SR_Install::onInstall(false); }
	public function onInitTimers() { Shadowrun4::initTimers(); }
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		# NO SPAM with it in other channels
		if ( ($server->getBotsNickname() !== $origin) && (!in_array($origin, self::$INCLUDE_CHANS, true)) )
		{
			return;
		}
		
		# Trigger?
		if (Common::startsWith($message, Shadowrun4::SR_SHORTCUT))
		{
			return Shadowrun4::onTrigger($server, $user, $origin, substr($message, 1));
		}
		
		# Location glob interlink (deprecated by #say)
//		if ($origin{0} === '#' && self::WITH_INTERLINK)
//		{
//			if (false !== ($player = Shadowrun4::getPlayerByUID($user->getID())))
//			{
//				if ($player->isCreated())
//				{
//					if ($player->getParty()->getAction() === 'inside')
//					{
//						if (false === ($channel = $server->getChannel('#shadowlamb'))) {
//							if (false === ($channel = $server->getChannel('#sr'))) {
//								return;
//							}
//						}
//						Shadowshout::onLocationGlobalMessage($server, $player, $channel, $message);
//					}
//				}
//			}
//		}
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
	
	public function getHelp()
	{
		return array(
			'sr' => '%CMD% <shadowrun command here>. Try '.Shadowrun4::SR_SHORTCUT.'help.',
		);
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