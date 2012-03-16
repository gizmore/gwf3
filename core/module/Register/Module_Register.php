<?php
/**
 * Registration Module.
 * To fight spammers it can help to set "ip_usetime" to 24h.
 * @todo Moderation mode.
 * @author gizmore
 */
final class Module_Register extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onCronjob() { require_once 'GWF_RegisterCronjob.php'; GWF_RegisterCronjob::onCronjob($this); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/register'); }
	public function getClasses() { return array('GWF_UserActivation'); }
	
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'email_activation' => array(true, 'bool'),
			'auto_login' => array(true, 'bool'),
			'country_select' => array(false, 'bool'),
			'min_age' => array('0', 'int', '0', '42'),
			'ip_usetime' => array('1 seconds', 'time', '0', 60*60*24*365),
			'force_tos' => array(true, 'bool'),
			'captcha' => array(false, 'bool'),
			'email_twice' => array(false, 'bool'),
			'plaintextpass' => array(false, 'bool'),
			'activation_pp' => array('50', 'int', '1', '250'),
			'ua_threshold' => array('24 hours', 'time', 60*15, 60*60*24*7),
			'reg_toslink' => array(GWF_WEB_ROOT.'tos', 'text', 0 , 512),
			'reg_detect_country' => array(true, 'bool'),
//			'signup_moderation' => array(false, 'bool'),
		));
	}
	public function wantEmailActivation() { return $this->getModuleVarBool('email_activation', '1'); }
	public function wantAutoLogin() { return $this->getModuleVarBool('auto_login', '1'); }
	public function wantCountrySelect() { return $this->getModuleVarBool('country_select', '0'); }
	public function hasMinAge() { return $this->getModuleVar('min_age', 0) > 0; }
	public function getMinAge() { return $this->getModuleVarInt('min_age', 0); }
	public function isTOSForced() { return $this->getModuleVarBool('force_tos', '1'); }
	public function wantCaptcha() { return $this->getModuleVarBool('captcha', '1'); }
	public function isEMailAllowedTwice() { return $this->getModuleVarBool('email_twice', '0'); }
	public function isPlaintextInEmail() { return $this->getModuleVarBool('plaintextpass', '0'); }
	public function getIPTimeout() { return $this->getModuleVar('ip_usetime', 1); }
	public function getActivationsPerPage() { return $this->getModuleVarInt('activation_pp', 50); }
	public function getActivationThreshold() { return $this->getModuleVar('ua_threshold', 86400); }
	public function cfgHrefTos() { return $this->getModuleVar('reg_toslink', GWF_WEB_ROOT.'tos'); }
	public function cfgDetectCountry() { return $this->getModuleVarBool('reg_detect_country', '1'); }
//	public function cfgModerated() { return $this->getModuleVarBool('signup_moderation', '0'); }
	
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
