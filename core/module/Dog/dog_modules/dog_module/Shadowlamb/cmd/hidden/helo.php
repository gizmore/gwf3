<?php
final class Shadowcmd_helo extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$player->message(sprintf('Welcome back to Shadowlamb, %s!', $player->getName()));
		return true;
	}
}
?>