<?php
final class Shadowcmd_ccommands extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$commands = array_merge(self::$CMDS_ALWAYS_CREATE, self::$CMDS_ALWAYS_HIDDEN, self::$CMDS_LEADER_ALWAYS);
		$bot->reply(sprintf('Hidden commands: %s.', implode(',', $commands)));
	}
}
?>