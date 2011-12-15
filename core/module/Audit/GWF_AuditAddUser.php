<?php
/**
 * This table runs as root on warchall.
 * @author gizmore
 */
final class GWF_AuditAddUser extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'audit_add_user'; }
	public function getColumnDefines()
	{
		return array(
			'username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::PRIMARY_KEY, 32),
			'password' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S, GDO::NULL),
		);
	}
}
?>