<?php
final class GWF_AuditMails extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'audit_mails'; }
	public function getColumnDefines()
	{
		return array(
			'am_username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'am_email' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
		);
	}
	
	public function getEMail(GWF_AuditLog $log)
	{
		$username = GDO::escape($log->getVar('al_eusername'));
		return self::table(__CLASS__)->selectVar('am_email', "am_username='$username'");
	}
	
}
?>