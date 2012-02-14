<?php
final class Shadowcmd_commands extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$boldify = true;
		$long_versions = isset($args[0]);
		$commands = self::getCurrentCommands($player, false, $boldify, $long_versions, true);
		
		return self::rply($player, '5042', array(implode(',', $commands)));
// 		return Shadowrap::instance($player)->reply(sprintf('Cmds: %s.', implode(',', $commands)));
	}
}
?>