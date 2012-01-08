<?php
/**
 * The audit module can capture and replay sudosh logfiles :)
 * @author gizmore
 */
final class Module_Audit extends GWF_Module
{
	const DEFAULT_LOGFILE = '/var/log/remote/box1/local2';
	
	public function getVersion() { return 1.04; }
	public function getClasses() { return array('GWF_AuditAddUser', 'GWF_AuditLog', 'GWF_AuditLogin', 'GWF_AuditMails'); }
	public function onCronjob() { $this->includeClass('GWF_AuditCronjob'); GWF_AuditCronjob::onCronjob($this); }
	public function onInstall($dropTable) { $this->includeClass('GWF_AuditInstall'); return GWF_AuditInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/audit'); }
	
	public function cfgLogfile() { return $this->getModuleVarString('logfile', self::DEFAULT_LOGFILE); }
}
?>
