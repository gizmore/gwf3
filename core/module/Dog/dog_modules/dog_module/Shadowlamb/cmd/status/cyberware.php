<?php
final class Shadowcmd_cyberware extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowfunc::getCyberware($player, '5045', $player));
	}
}
?>
