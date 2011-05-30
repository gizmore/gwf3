<?php
final class Shadowcmd_party extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(Shadowfunc::getPartyStatus($player));
		return true;
	}
}
?>
