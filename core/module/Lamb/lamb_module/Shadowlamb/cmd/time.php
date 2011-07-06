<?php
final class Shadowcmd_time extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$time = Shadowrun4::getTime();
		return $bot->reply('It is the year 2064 + '.GWF_Time::humanDuration($time, 4));
	}
}
?>