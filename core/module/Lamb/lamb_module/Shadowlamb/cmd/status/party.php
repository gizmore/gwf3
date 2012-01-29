<?php
final class Shadowcmd_party extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return Shadowrap::instance($player)->reply(Shadowfunc::getPartyStatus($player));
	}
}
?>
