<?php
final class Shadowcmd_uid extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		self::reply($player, sprintf('Your PID is: %d. Your UID is: %d. Your PartyID is: %d.', 
			$player->getID(), $player->getUID(), $player->getPartyID()
		));
	}
}
?>
