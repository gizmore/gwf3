<?php
/**
 * Send a message to all players in shadowlamb.
 * @author gizmore
 */
final class Shadowcmd_gmn extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'gmn'));
			return false;
		}
		
		$message = "\X02[Shadowlamb]\X02 ".implode(' ', $args);
		
		foreach (Shadowrun4::getPlayers() as $player)
		{
			$player instanceof SR_Player;
			$player->message($message);
		}
		return true;
	}
}
?>
