<?php
final class Module_Register extends GWF_Module
{
	public function getVersion() { return 1.00; }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onCronjob() { require_once 'GWF_RegisterCronjob.php'; GWF_RegisterCronjob::onCronjob($this); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/register'); }
	public function getClasses() { return array('GWF_UserActivation'); }
	
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'email_activation' => array('YES', 'bool'),
			'auto_login' => array('YES', 'bool'),
			'country_select' => array('NO', 'bool'),
			'min_age' => array('0', 'int', '0', '42'),
			'ip_usetime' => array('1 seconds', 'time', '0', 60*60*24*365),
			'force_tos' => array('YES', 'bool'),
			'captcha' => array('NO', 'bool'),
			'email_twice' => array('NO', 'bool'),
			'plaintextpass' => array('NO', 'bool'),
			'activation_pp' => array('50', 'int', '1', '250'),
			'ua_threshold' => array('24 hours', 'time', 60*15, 60*60*24*7),
			'reg_toslink' => array(GWF_WEB_ROOT.'tos', 'text', 0 , 512),
			'reg_detect_country' => array('YES', 'bool'),
		));
	}
	public function wantEmailActivation() { return $this->getModuleVar('email_activation', '1') === '1'; }
	public function wantAutoLogin() { return $this->getModuleVar('auto_login', '1') === '1'; }
	public function wantCountrySelect() { return $this->getModuleVar('country_select', '0') === '1'; }
	public function hasMinAge() { return $this->getModuleVar('min_age', 0) > 0; }
	public function getMinAge() { return (int) $this->getModuleVar('min_age', 0); }
	public function isTOSForced() { return $this->getModuleVar('force_tos', '1') === '1'; }
	public function wantCaptcha() { return $this->getModuleVar('captcha', '1') === '1'; }
	public function isEMailAllowedTwice() { return $this->getModuleVar('email_twice', '0') === '1'; }
	public function isPlaintextInEmail() { return $this->getModuleVar('plaintextpass', '0') === '1'; }
	public function getIPTimeout() { return $this->getModuleVar('ip_usetime', 1); }
	public function getActivationsPerPage() { return $this->getModuleVar('activation_pp', 50); }
	public function getActivationThreshold() { return $this->getModuleVar('ua_threshold', 86400); }
	public function cfgHrefTos() { return $this->getModuleVar('reg_toslink', GWF_WEB_ROOT.'tos'); }
	public function cfgDetectCountry() { return $this->getModuleVar('reg_detect_country', '1') === '1'; }
	
	public function hasIPActivatedRecently()
	{
		$duration = $this->getIPTimeout();
		$users = GDO::table('GWF_User');
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$duration);
		$ip = $users->escape(GWF_IP6::getIP(GWF_IP_EXACT));
		return $users->selectFirst('1',"user_regip='$ip' AND user_regdate>'$cut'") !== false;
	}
}
?>
