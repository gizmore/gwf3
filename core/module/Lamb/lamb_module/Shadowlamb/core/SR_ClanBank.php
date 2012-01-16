<?php
final class SR_ClanBank extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_bank'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cb_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cb_iname' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cb_iamt' => array(GDO::UINT, 1),
			'sr4cb_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
// 			'sr4cb_pid' => array(GDO::UINT, GDO::NOT_NULL),
// 			'sr4cb_pname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
		);
	}

	public static function push(SR_Clan $clan, $itemname, $amt)
	{
		
	}
}
?>