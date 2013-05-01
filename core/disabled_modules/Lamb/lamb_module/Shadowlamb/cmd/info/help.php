<?php
final class Shadowcmd_help extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$help = Shadowhelp::getHelp($player, isset($args[0])?$args[0]:'');
		return Shadowrap::instance($player)->reply($help);
	}
}
?>
