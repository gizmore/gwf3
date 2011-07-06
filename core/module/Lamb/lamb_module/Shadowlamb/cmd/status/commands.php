<?php
final class Shadowcmd_commands extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$commands = self::getCurrentCommands($player, false);
		$bot->reply(sprintf('Cmds: %s.', implode(',', $commands)));
		return true;
	}
}
?>