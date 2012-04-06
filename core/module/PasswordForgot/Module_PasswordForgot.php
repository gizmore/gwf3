<?php
/**
 * Forgot your password?
 * You need a confirmed email then!
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
final class Module_PasswordForgot extends GWF_Module
{
	public function getVersion() { return 1.00; }
	public function isCoreModule() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pwrecover'); }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'captcha' => array(false, 'bool'),
			'mail_sender' => array(GWF_SUPPORT_EMAIL, 'text', '6', '128'),
		));
	}
	public function wantCaptcha() { return $this->getModuleVarBool('captcha', '1'); }
	public function getMailSender() { return $this->getModuleVar('mail_sender', GWF_SUPPORT_EMAIL); }
}
?>
