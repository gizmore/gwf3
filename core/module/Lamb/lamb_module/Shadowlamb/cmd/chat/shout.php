<?php
final class Shadowcmd_shout extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0) {
			Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'shout'));
			return false;
		}
		Shadowshout::shout($player, implode(' ', $args));
		return true;
	}
}
?>
