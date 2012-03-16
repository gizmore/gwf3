<?php
final class Module_Shoutbox extends GWF_Module
{
	private static $instance;
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.01; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/shoutbox'); }
	public function getClasses() { return array('GWF_Shoutbox'); }
	public function onStartup() { self::$instance = $this; }
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'sb_guests' => array(true, 'bool'),
			'sb_guest_captcha' => array(false, 'bool'),
			'sb_member_captcha' => array(false, 'bool'),
			'sb_ipp' => array('25', 'int', 1, 512),
			'sb_ippbox' => array('6', 'int', 1, 64),
			'sb_maxlen' => array('196', 'int', 16, 1024),
			'sb_timeout' => array('60', 'time', 0, GWF_Time::ONE_DAY*2),
			'sb_maxdayu' => array('12', 'int', 1, 1024),
			'sb_maxdayg' => array('6', 'int', 1, 1024),
			'sb_email_moderation' => array(true, 'bool'), 
		));
	}
	public function cfgMaxlen() { return $this->getModuleVarInt('sb_maxlen', 196); }
	public function cfgIPP() { return $this->getModuleVarInt('sb_ipp', 25); }
	public function cfgIPPBox() { return $this->getModuleVarInt('sb_ippbox', 6); }
	public function cfgGuestShouts() { return $this->getModuleVarBool('sb_guests', '1'); }
	public function cfgCaptcha() { return GWF_User::isLoggedIn() ? $this->cfgMemberCaptcha() : $this->cfgGuestCaptcha(); }
	public function cfgGuestCaptcha() { return $this->getModuleVarBool('sb_guest_captcha', '0'); }
	public function cfgMemberCaptcha() { return $this->getModuleVarBool('sb_member_captcha', '0'); }
	public function cfgTimeout() { return $this->getModuleVarInt('sb_timeout', 60); }
	public function cfgMaxPerDayUser() { return $this->getModuleVarInt('sb_maxdayu', 12); }
	public function cfgMaxPerDayGuest() { return $this->getModuleVarInt('sb_maxdayg', 6); }
	public function cfgEMailModeration() { return $this->getModuleVarBool('sb_email_moderation', '1'); }
	
	############
	### HREF ###
	############
	public function hrefShout() { return $this->getMethodURL('Shout'); }
	public function hrefHistory() { return $this->getMethodURL('History'); }
	
	#########################
	### Static Inline Box ###
	#########################
	public static function templateBoxS()
	{
		return self::$instance->templateBox();
	}
	public function templateBox()
	{
		if (!$this->isEnabled()) {
			return '';
		}
		self::$instance->onInclude();
		self::$instance->onLoadLanguage();
		$tVars = array(
			'form_action' => GWF_HTML::display($this->hrefShout()),
			'href_history' => GWF_HTML::display($this->hrefHistory()),
			'msgs' => array_reverse(GDO::table('GWF_Shoutbox')->selectAll('*', '', 'shout_date DESC', array('shout_uid'), $this->cfgIPPBox(), 0, GDO::ARRAY_O)),
			'captcha' => $this->getCaptcha(),
		);
		
		return $this->templatePHP('box.php', $tVars);
	}
	
	public function getCaptcha()
	{
		if (!$this->cfgCaptcha()) {
			return false;
		}
		return GWF_Form::captcha();
	}
	
}
?>
