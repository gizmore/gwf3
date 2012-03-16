<?php
/**
 * Login and Logout
 * @author gizmore
 */
final class Module_Login extends GWF_Module
{
	public function getVersion() { return 1.02; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/login'); }
	public function getClasses() { return array('GWF_LoginCleared', 'GWF_LoginFailure', 'GWF_LoginHistory'); }
	public function isCoreModule() { return true; }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
				'captcha' => array(false, 'bool'),
				'max_tries' => array('6', 'int', '1', '100'),
				'try_exceed' => array('600', 'time', '0', 60*60*24),
				'lf_cleanup_t' => array('1 month', 'time', '0', 60*60*24*365*8),
				'lf_cleanup_i' => array(true, 'bool'),
				'send_alerts' => array(true, 'bool'),
			));
	}
	public function cfgCaptcha() { return $this->getModuleVarBool('captcha', '1'); }
	public function cfgMaxTries() { return $this->getModuleVarInt('max_tries', 6); } 
	public function cfgTryExceed() { return $this->getModuleVar('try_exceed', 600); }
	public function cfgCleanupTime() { return $this->getModuleVar('lf_cleanup_t', 2592000); }
	public function cfgCleanupAlways() { return $this->getModuleVarBool('lf_cleanup_i', '1'); }
	public function cfgAlerts() { return $this->getModuleVarBool('send_alerts'); }
	
	public function onCronjob() { GWF_LoginFailure::cleanupCron($this->cfgCleanupTime()); }
}

?>
