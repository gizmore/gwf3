<?php
final class Shadowcmd_equipment extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply('Your equipment: '.Shadowfunc::getEquipment($player).'.');
		return true;
	}
}
?>