<?php
final class Shadowcmd_skills extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::rply($player, '5006', array(Shadowfunc::getSkills($player)));
// 		$bot = Shadowrap::instance($player);
// 		$bot->reply(sprintf('Your skills: %s.', Shadowfunc::getSkills($player)));
// 		return true;
	}
}
?>