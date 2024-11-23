<?php
final class Shadowcmd_ccommands extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$long_versions = isset($args[0]);
		$commands = self::getCurrentCommands($player, true, true, $long_versions, true, true, true);
		return $player->msg('5037', array(implode(',', $commands)));
	}
}
?>
