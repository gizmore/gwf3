<?php
final class Shadowcmd_backward extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		return $player->getParty()->backward($player, SR_Player::BACKWARD_TIME);
	}
}
?>
