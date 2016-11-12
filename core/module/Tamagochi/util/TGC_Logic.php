<?php
final class TGC_Logic
{
	public static function levelForXP($xp)
	{
		$level = $xp < 5 ? 0 : ceil(sqrt(sqrt($xp / 1000)));
		return Common::clamp($level, 0, count(TGC_Const::$LEVELS));
	}
	
	public static function arePlayersNearEachOther(TGC_Player $a, TGC_Player $b)
	{
		return self::arePositionsNearEachOther($a->lat(), $a->lng(), $b->lat(), $b->lng());
	}
	
	public static function arePositionsNearEachOther($latA, $lngA, $latB, $lngB)
	{
		return TGC_Position::distanceCalculation($latA, $lngA, $latB, $lngB);
	}
	
}
