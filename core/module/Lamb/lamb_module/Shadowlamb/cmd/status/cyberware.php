<?php
final class Shadowcmd_cyberware extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::rply($player, '5045', array(Shadowfunc::getCyberware($player)));
	}
}
?>
