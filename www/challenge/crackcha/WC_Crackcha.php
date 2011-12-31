<?php
final class WC_Crackcha extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_chall_crackcha'; }
	public function getColumnDefines()
	{
		return array(
			'wccc_id' => array(GDO::AUTO_INCREMENT),
			'wccc_uid' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_User', 'wccc_uid', 'user_id')),
			'wccc_start' => array(GDO::DATE, GDO::NOT_NULL, GWF_DATE::LEN_SECOND),
			'wccc_time' => array(GDO::UINT, GDO::NOT_NULL),
			'wccc_rate' => array(GDO::DECIMAL, GDO::NOT_NULL, array(3,2)),
			'wccc_count' => array(GDO::UINT, GDO::NOT_NULL),
			'wccc_solved' => array(GDO::UINT, GDO::NOT_NULL),
			'wccc_failed' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function insertCrackord(WC_Challenge $chall, $uid, $start, $time, $solved, $count)
	{
		if ($count === 0) { return true; }
		
		$failed = $count - $solved;
		$rate = $count > 0 ? ($solved/$count*100) : 0;
		$entry = new self(array(
			'wccc_id' => 0,
			'wccc_uid' => $uid,
			'wccc_start' => GWF_Time::getDate(GWF_DATE::LEN_SECOND, intval($start)),
			'wccc_time' => intval(round($time)),
			'wccc_rate' => round($rate, 2),
			'wccc_count' => $count,
			'wccc_solved' => $solved,
			'wccc_failed' => $failed,
		));
		return $entry->insert();
	}
}
?>