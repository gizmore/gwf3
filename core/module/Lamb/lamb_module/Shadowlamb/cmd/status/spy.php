<?php
final class Shadowcmd_spy extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply('This command is not implemented yet.');
	}
}