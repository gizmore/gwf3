<?php
final class SR_Clan extends GDO
{
	const MIN_MEMBERCOUNT = 1;
	const MAX_MEMBERCOUNT = 50;
	const MIN_STORAGE = 1000; # 1kg
	const MAX_STORAGE = 500000; # 500kg
	
	const MAX_SLOGAN_LEN = 196;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cl_id' => array(GDO::AUTO_INCREMENT),
			'sr4cl_pname' => array(GDO::UINT, 0),
			'sr4cl_slogan' => array(GDO::TEXT|GDO::CASE_I|GDO::UTF8),
			'sr4cl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sr4cl_members' => array(GDO::UINT, 0),
			'sr4cl_max_members' => array(GDO::UINT, self::MIN_MEMBERCOUNT),
			'sr4cl_storage' => array(GDO::UINT, 0),
			'sr4cl_max_storage' => array(GDO::UINT, self::MIN_STORAGE),
		);
	}
	
}
?>