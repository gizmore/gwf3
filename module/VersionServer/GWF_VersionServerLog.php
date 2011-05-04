<?php
final class GWF_VersionServerLog extends GDO
{
	const TOKEN_LEN = 12;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }	
	public function getTableName() { return GWF_TABLE_PREFIX.'vs_log'; }
	public function getColumnDefines()
	{
		return array(
			'vsl_token' => array(GDO::TOKEN|GDO::INDEX, GDO::NOT_NULL, self::TOKEN_LEN), # update token
			'vsl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'vsl_type' => array(GDO::ENUM, GDO::NOT_NULL, array('check', 'update', 'install')),
			'vsl_module' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 63),
			'vsl_status' => array(GDO::TINYINT, 0),
		);
	}
}
?>