<?php
final class Shadowcmd_status extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowfunc::getStatus($player));
	}
}
?>