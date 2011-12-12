<?php
final class GWF_AuditLogin extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'audit_login'; }
	public function getColumnDefines()
	{
		return array(
			'ali_username' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
			'ali_time' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
}
?>