<?php
final class Shadowcmd_time extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$realtime = Shadowrun4::getRealTime();
		
		$hours = explode(':', date('y:m:d:h:i:s', $realtime));
		$y = $hours[0] + 2064 - 70;
		$m = $hours[1]; $d = $hours[2];
		$h = $hours[3]; $i = $hours[4]; $s = $hours[5];
		
		self::rply($player, '5309', array($h, $i, $s, $d, $m, $y));
		
		if (false !== ($loc = $player->getParty()->getLocationClass()))
		{
			$hs = sprintf('%02d', $loc->getOpenHour());
			$he = sprintf('%02d', $hs + $loc->getOpenHours());
			$ms = sprintf('%02d', $loc->getOpenMin());
			$me = sprintf('%02d', $loc->getOpenMins());
			self::rply($player, '5310', array($loc->getName(), $hs, $ms, $he, $me));
		}
#		self::rply($player, '5243', array(GWF_Time::humanDuration(Shadowrun4::getTime(), 4)));
	}
}
?>