<?php
/**
 * Guestbook Module.
 * @author gizmore
 * @version 1.0
 */
final class Module_Guestbook extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.02; }
	public function getDefaultPriority() { return 41; } # Startup early
	public function getClasses() { return array('GWF_Guestbook', 'GWF_GuestbookMSG'); }
	public function onInstall($dropTable) { require_once 'GWF_GuestbookInstall.php'; return GWF_GuestbookInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/gb'); }
	##############
	### Config ###
	##############
	public function cfgItemsPerPage() { return (int)$this->getModuleVar('gb_ipp', 10); }
	public function cfgAllowURL() { return $this->getModuleVar('gb_allow_url', '1') === '1'; }
	public function cfgAllowEMail() { return $this->getModuleVar('gb_allow_email', '1') === '1'; }
	public function cfgAllowGuest() { return $this->getModuleVar('gb_allow_guest', '1' === '1'); }
	public function cfgGuestCaptcha() { return $this->getModuleVar('gb_captcha', '1') === '1'; }
	public function cfgMaxUsernameLen() { return (int)$this->getModuleVar('gb_max_ulen', GWF_User::USERNAME_LENGTH); }
	public function cfgMaxMessageLen() { return (int)$this->getModuleVar('gb_max_msglen', 1024); }
	public function cfgMaxTitleLen() { return (int)$this->getModuleVar('gb_max_titlelen', 63); }
	public function cfgMaxDescrLen() { return (int)$this->getModuleVar('gb_max_descrlen', 255); }
	public function cfgLevel() { return (int)$this->getModuleVar('gb_level', 0); }
	public function cfgNesting() { return $this->getModuleVar('gb_nesting', '1') === 'true'; }
	###############
	### Upgrade ###
	###############
//	public function onUpgrade_1_01()
//	{
//		$gbe = GWF_TABLE_PREFIX.'guestbook_entry';
//		$query = "ALTER TABLE `$gbe` ADD `gbm_replyto` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';";
//		$db = gdo_db();
//		if (false === $db->queryWrite($query)) {
//			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//		}
//		return '';
//	}	
	
	
	###########
	### API ###
	###########
	public function canCreateGuestbook($user)
	{
		# Logged in?
		if ($user === false || $user->getID() === 0) {
			return false;
		}
		# Level?
		if ($user->getLevel() < $this->cfgLevel()) {
			return false;
		}
		return true;
	}
	
	public function hasGuestbook($userid)
	{
		return $this->getGuestbook($userid) !== false;
	}
	
	/**
	 * Get a guestbook by userid.
	 * @param int $userid
	 * @return GWF_Guestbook
	 */
	public function getGuestbook($userid)
	{
		return GWF_Guestbook::getByUID($userid);
	}
	
//	public function hrefEdit($userid)
//	{
//		if (false === ($gb = $this->getGuestbook($userid))) {
//			return '#';
//		}
//		return $gb->hrefEdit();
//	}
	
}
?>
