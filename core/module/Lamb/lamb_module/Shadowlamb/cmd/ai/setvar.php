<?php
final class Shadowcmd_setvar extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$player->setAiVar($args[0], $args[1]);
		$player->message(sprintf('Welcome back to Shadowlamb, %s!', $player->getName()));
		return true;
	}
}
?>