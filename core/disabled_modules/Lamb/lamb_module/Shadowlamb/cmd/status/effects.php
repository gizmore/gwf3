<?php
final class Shadowcmd_effects extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::rply($player, '5047', array(Shadowfunc::getEffects($player)));
// 		$bot = Shadowrap::instance($player);
// 		$bot->reply(sprintf('Your effects: %s.', Shadowfunc::getEffects($player)));
// 		return true;
	}
}
?>
