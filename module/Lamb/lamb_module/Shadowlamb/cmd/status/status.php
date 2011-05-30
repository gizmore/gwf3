<?php
final class Shadowcmd_status extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return Shadowrap::instance($player)->reply(Shadowfunc::getStatus($player));
	}
}
?>