<?php
final class Shadowcmd_time extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		self::rply($player, '5243', array(GWF_Time::humanDuration(Shadowrun4::getTime(), 4)));
// 		$bot = Shadowrap::instance($player);
// 		$time = Shadowrun4::getTime();
// 		return $bot->reply('It is the year 2064 + '.GWF_Time::humanDuration($time, 4));
	}
}
?>