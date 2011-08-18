<?php
final class Shadowcmd_xp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowhelp::getHelp($player, 'xp'));
	}
}
?>
