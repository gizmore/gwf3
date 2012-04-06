<?php
/**
 * Contact Module.
 * Provides contact to admins, and
 * Write users a mail without spoiling their email.
 * @author gizmore
 */
final class Module_Contact extends GWF_Module
{
	# Module
	public function onLoadLanguage() { return $this->loadLanguage('lang/contact'); }
	public function onAddMenu() { GWF_TopMenu::addMenu('contact', GWF_WEB_ROOT.'contact', '', $this->isSelected()); }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'captcha' => array(true, 'bool'),
			'captcha_member' => array(false, 'bool'),
			'email' => array(GWF_SUPPORT_EMAIL, 'text', '0', GWF_User::EMAIL_LENGTH),
			'icq' => array('', 'text', '0', '32'),
			'skype' => array('', 'text', '0', '128'),
			'maxmsglen' => array('1024', 'int', '16', '8192'),
		));
	}
	# Config
	public function cfgCaptchaGuest() { return $this->getModuleVarBool('captcha', '1'); }
	public function cfgCaptchaMember() { return $this->getModuleVarBool('captcha_member', '0'); }
	public function isCaptchaEnabled() { return GWF_Session::isLoggedIn() ? $this->cfgCaptchaMember() : $this->cfgCaptchaGuest(); }
	public function getContactEMail() { return $this->getModuleVar('email', GWF_SUPPORT_EMAIL); }
	public function getContactICQ() { return $this->getModuleVar('icq', ''); }
	public function getContactSkype() { return $this->getModuleVar('skype', ''); }
	public function cfgMaxMsgLen() { return $this->getModuleVarInt('maxmsglen', 1024); }
}
?>