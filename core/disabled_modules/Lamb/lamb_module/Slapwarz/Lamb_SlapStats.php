<?php
final class Lamb_SlapStats extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_slap_stats'; }
	public function getColumnDefines()
	{
		return array(
			'lss_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lss_iid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lss_scored' => array(GDO::TINYINT|GDO::UNSIGNED|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lss_count' => array(GDO::UINT, 0),
		);
	}
	
	public static function increaseStats($userid, $itemid, $scored)
	{
		$scored = $scored == 1 ? '1' : '0';
		$table = self::table(__CLASS__);
		if (false === ($row = self::table(__CLASS__)->getRow($userid, $itemid, $scored))) {
			return $table->insertAssoc(array(
				'lss_uid' => $userid,
				'lss_iid' => $itemid,
				'lss_scored' => $scored,
				'lss_count' => 1,
			));
		}
		return $row->increase('lss_count', 1);
	}
}
?>