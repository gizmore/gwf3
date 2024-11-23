<?php
final class Shadowcmd_equipment extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowfunc::getEquipment($player, '5048'));
	}
}
?>
