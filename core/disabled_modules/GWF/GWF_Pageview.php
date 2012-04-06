<?php
/**
 * Simple Pageview counter.
 * @author gizmore
 */
final class GWF_Pageview extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'pageview'; }
	public function getColumnDefines()
	{
		return array(
			'pv_date' => array(GDO::DATE|GDO::PRIMARY_KEY, GDO::NOT_NULL, GWF_Date::LEN_DAY),
			'pv_views' => array(GDO::UINT, 0),
		);
	}

	###################
	### Convinience ###
	###################
	public static function increaseTodayView($by=1)
	{
		$by = (int)$by;
		$date = GWF_Time::getDate(GWF_Date::LEN_DAY);
		return self::table(__CLASS__)->update("pv_views=pv_views+$by", "pv_date='$date'");
	}
}

?>
