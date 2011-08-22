<?php
final class Shoutbox_Shout extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if ( (false === ($user = GWF_Session::getUser())) && (!$module->cfgGuestShouts()) ) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if ($user !== false && $user->isWebspider()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== ($error = $this->isFlooding($module))) {
			return $error;
		}
		
		$message = Common::getPost('message', '');
		if (false !== ($error = $this->validate_message($module, $message))) {
			return GWF_HTML::error('Shoutbox', $error);
		}

		if (false === GWF_Shoutbox::shout($message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$last_url = GWF_Session::getLastURL();
		
		return $module->message('msg_shouted', array(htmlspecialchars($last_url)));
	}
	
	public function isFlooding(Module_Shoutbox $module)
	{
		$uid = GWF_Session::getUserID();
		$uname = GWF_Shoutbox::generateUsername();
		$euname = GDO::escape($uname);
		$table = GDO::table('GWF_Shoutbox');
		
		$max = $uid === 0 ? $module->cfgMaxPerDayGuest() : $module->cfgMaxPerDayUser();
//		$cut = GWF_Time::getDate(GWF_Time::LEN_SECOND, time()-$module->cfgTimeout());
//		$cnt = $table->countRows("shout_uname='$euname' AND shout_date>'$cut'");
		
		# Check captcha
		if ($module->cfgCaptcha()) {
			require_once 'core/inc/3p/Class_Captcha.php';
			if (!PhpCaptcha::Validate(Common::getPostString('captcha'), true)) {
				return GWF_HTML::err('ERR_WRONG_CAPTCHA');
			}
		}
		
		# Check date
		$timeout = $module->cfgTimeout();
		$last_date = $table->selectVar('MAX(shout_date)', "shout_uid=$uid AND shout_uname='$euname'");
		$last_time = $last_date === NULL ? 0 : GWF_Time::getTimestamp($last_date);
		$next_time = $last_time+$timeout;
		if ($last_time+$timeout > time()) {
			return $module->error('err_flood_time', array(GWF_Time::humanDuration($next_time - time())));
		}
		
		# Check amount
		$today = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$timeout);
		$count = $table->countRows("shout_uid=$uid AND shout_date>='$today'");
		if ($count >= $max) {
			return $module->error('err_flood_limit', array($max));
		}
		
		# All fine
		return false;
	}
	
	public function validate_message(Module_Shoutbox $module, $message)
	{
		return GWF_Validator::validateString($module, 'message', $message, 1, $module->cfgMaxlen(), true);
	}
}
?>