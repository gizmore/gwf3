<?php
final class Shadowcmd_status extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::reply($player, Shadowfunc::getStatus($player));
	}
}
?>