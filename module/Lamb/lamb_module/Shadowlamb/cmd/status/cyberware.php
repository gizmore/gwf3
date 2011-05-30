<?php
final class Shadowcmd_cyberware extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply('Your cyberware: '.Shadowfunc::getCyberware($player));
		return true;
	}
}
?>
