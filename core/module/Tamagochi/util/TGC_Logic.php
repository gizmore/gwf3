<?php
final class TGC_Logic
{
	public static function levelForXP($xp)
	{
		return $xp < 5 ? 0 : ceil(sqrt($xp-4));
	}
	
	public static function arePlayersNearEachOther(TGC_Player $a, TGC_Player $b)
	{
		return self::arePositionsNearEachOther($a->lat(), $a->lng(), $b->lat(), $b->lng());
	}
	
	public static function arePositionsNearEachOther($latA, $lngA, $latB, $lngB)
	{
		return false;
	}
	
}
