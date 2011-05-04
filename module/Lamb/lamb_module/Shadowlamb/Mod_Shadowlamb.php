<?php
require_once 'Shadowrun4.php';

final class LambModule_Shadowlamb extends Lamb_Module
{
	const SR_SHORTCUT = '#';
	
	# Hardcoded shadowlamb channels for shortcuts
	public static $INCLUDE_CHANS = array('#sr', '#shadowlamb', '#wechall');
	
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server) { Shadowrun4::init($server); }
	public function onInstall() { require_once 'SR_Install.php'; SR_Install::onInstall(false); }
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (!in_array($origin, self::$INCLUDE_CHANS, true)) {
			return;
		}
		if (Common::startsWith($message, self::SR_SHORTCUT)) {
			return Lamb::instance()->processMessageA($server, LAMB_TRIGGER.'sr '.substr($message, 1), $from);
		}
	}
	public function onTimer() { /*Shadowrun4::onTimer();*/ }
	
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