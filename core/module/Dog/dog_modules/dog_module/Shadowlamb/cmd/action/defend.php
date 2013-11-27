<?php
final class Shadowcmd_defend extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static $TIMES = array(60, 50, 45, 40);
	public static $MODES = array(array('tank'),array('self'),array('party'),array('lure'));
	public static $BONUS = array(0.8, 0.6, 0.4, 0.2);
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			$mode = 1;
		}
		return true;
	}
}
?>