<?php
/**
 * @author gizmore
 * @version 1.0
 */
final class Module_Wanda extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	private static $instance;
	public static function instance()
	{
		return self::$instance;
	}
	
	public function getVersion() { return 1.00; }
	public function getDefaultPriority() { return 64; }
// 	public function getClasses() { return array('GWF_Guestbook', 'GWF_GuestbookMSG'); }
// 	public function onInstall($dropTable) { require_once 'GWF_GuestbookInstall.php'; return GWF_GuestbookInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/itmb'); }
	##############
	### Config ###
	##############
// 	public function cfgItemsPerPage() { return $this->getModuleVarInt('gb_ipp', 10); }
// 	public function cfgAllowURL() { return $this->getModuleVarBool('gb_allow_url', '1'); }
// 	public function cfgAllowEMail() { return $this->getModuleVarBool('gb_allow_email', '1'); }
// 	public function cfgAllowGuest() { return $this->getModuleVarBool('gb_allow_guest', '1'); }
// 	public function cfgGuestCaptcha() { return $this->getModuleVarBool('gb_captcha', '1'); }
// 	public function cfgMaxUsernameLen() { return $this->getModuleVarInt('gb_max_ulen', GWF_User::USERNAME_LENGTH); }
// 	public function cfgMaxMessageLen() { return $this->getModuleVarInt('gb_max_msglen', 1024); }
// 	public function cfgMaxTitleLen() { return $this->getModuleVarInt('gb_max_titlelen', 63); }
// 	public function cfgMaxDescrLen() { return $this->getModuleVarInt('gb_max_descrlen', 255); }
// 	public function cfgLevel() { return $this->getModuleVarInt('gb_level', 0); }
// 	public function cfgNesting() { return $this->getModuleVarBool('gb_nesting', '1'); }
	###############
	### Upgrade ###
	###############
	public function onStartup()
	{
		self::$instance = $this;
	}
	
	public function wandimage($book, $page, $image)
	{
		
	}
}
