<?php
/**
 * Send a message to all channels in shadowlamb.
 * @author gizmore
 */
final class Shadowcmd_gmm extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'gmm'));
			return false;
		}
		return self::sendGlobalMessage("\X02[Shadowlamb]\X02 ".implode(' ', $args));
	}
	
	public static function sendGlobalMessage($message)
	{
		return Shadowshout::sendGlobalMessage($message);		
	}
}
?>
