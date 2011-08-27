<?php
final class Shadowcmd_idle extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$player->setCombatETA(9999);
		return true;
	}
}
?>