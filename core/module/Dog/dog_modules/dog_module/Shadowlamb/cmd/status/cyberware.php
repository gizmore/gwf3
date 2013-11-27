<?php
final class Shadowcmd_cyberware extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::reply($player, Shadowfunc::getCyberware($player, '5045', $player));
	}
}
?>
