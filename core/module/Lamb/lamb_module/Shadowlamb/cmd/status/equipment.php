<?php
final class Shadowcmd_equipment extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::rply($player, '5048', array(Shadowfunc::getEquipment($player)));
	}
}
?>
