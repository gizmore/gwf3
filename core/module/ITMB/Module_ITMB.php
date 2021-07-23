<?php
/**
 * @author gizmore
 * @version 1.0
 */
final class Module_ITMB extends GWF_Module
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
	public function onStartup()
	{
		self::$instance = $this;
		if ($clickPath = ($this->getClickCounterPath()))
		{
			GWF_CachedCounter::getAndCount($clickPath);
		}
	}
	
	private function getClickCounterPath()
	{
		if (isset($_GET['mo']))
		{
			$mo = Common::getGetString('mo');
			$me = Common::getGetString('me');
			$mo .= str_repeat('_', 20 - strlen($mo));
			return sprintf("CLICK_%s=>%s", $mo, $me);
		}
		return null;
	}
	
}
