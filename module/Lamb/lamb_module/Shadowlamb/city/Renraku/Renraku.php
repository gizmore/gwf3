<?php
final class Renraku extends SR_City
{
	public function isDungeon() { return true; }
	public function getArriveText() { return 'You enter the Renraku office. "Stay calm", you think by yourself.'; }
	public function getExploreTime() { return 120; }
	
	#############
	### Alert ###
	#############
	private static $ALERT = array();
	
	public static function isAlert(SR_Party $party)
	{
		$pid = $party->getID();
		return isset(self::$ALERT[$pid]) && self::$ALERT[$pid] > Shadowrun4::getTime();
	}
	
	public static function setAlert(SR_Party $party, $duration=600)
	{
		self::$ALERT[$pid] = Shadowrun4::getTime() + $duration;
	}
}
?>