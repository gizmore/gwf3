<?php
final class Shadowcmd_effects extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(sprintf('Your effects: %s.', Shadowfunc::getEffects($player)));
		return true;
	}
}
?>
