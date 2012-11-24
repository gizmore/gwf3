<?php
final class Shadowcmd_attack extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		return $player->getWeapon()->onAttack($player, isset($args[0])?$args[0]:'');
	}
}
?>