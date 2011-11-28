<?php
final class Module_Comments extends GWF_Module
{
	private static $INSTANCE;
	public static function instance() { return self::$INSTANCE; }
	public function onStartup() { self::$INSTANCE = $this; }
	
	public function getVersion() { return 1.00; }
	public function getClasses() { return array('GWF_Comment', 'GWF_Comments'); }
	public function onInstall($dropTable) { require_once 'GWF_CommentsInstall.php'; GWF_CommentsInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/comments'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Staff'); }
	
	public function cfgModerated() { return $this->getModuleVarBool('moderated', '1'); }
	public function cfgMaxMsgLen() { return $this->getModuleVar('max_msg_len', '2048'); }
	public function cfgGuestCaptcha() { return $this->getModuleVarBool('guest_captcha', '1'); }
	public function cfgMemberCaptcha() { return $this->getModuleVarBool('member_captcha', '0'); }
	public function cfgCaptcha($user) { return $user === false ? $this->cfgGuestCaptcha() : $this->cfgMemberCaptcha(); }
	
	public function validate_cmt_id($arg)
	{
		$arg = (int)$arg;
		if ($arg === 0)
		{
			return false;
		}
		return GWF_Comment::getByID($arg) === false ? $this->lang('err_comment') : false;
	}

	public function validate_cmts_id($arg, $check_enabled)
	{
		if (false === ($comments = GWF_Comments::getByID($arg)))
		{
			return $this->lang('err_comments');
		}
		
		if ( ($check_enabled) && (!$comments->isEnabled()) )
		{
			return $this->lang('err_disabled');
		}
		
		return false;
	}
}
?>
