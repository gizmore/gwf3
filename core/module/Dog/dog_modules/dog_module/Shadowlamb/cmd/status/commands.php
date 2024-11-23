<?php
final class Shadowcmd_commands extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$long_versions = isset($args[0]);
		$commands = self::getCurrentCommands($player, false, true, $long_versions, true, true);
		return $player->msg('5042', array(implode(',', $commands)));
	}
}
?>