<?php
final class Shoutbox_Shout extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if ( (false === ($user = GWF_Session::getUser())) && (!$this->_module->cfgGuestShouts()) ) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if ($user !== false && $user->isWebspider()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== ($error = $this->isFlooding($this->_module))) {
			return $error;
		}
		
		$message = Common::getPost('message', '');
		if (false !== ($error = $this->validate_message($this->_module, $message))) {
			return GWF_HTML::error('Shoutbox', $error);
		}
		
		$entry = new GWF_Shoutbox(array(
			'shout_id' => '0',
			'shout_uid' => GWF_Session::getUserID(),
			'shout_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'shout_uname' => GWF_Shoutbox::generateUsername(),
			'shout_message' => $message,
		));
		if (false === $entry->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if ($this->_module->cfgEMailModeration())
		{
			$this->onEMailModeration($this->_module, $user, $entry);
		}

		$url = htmlspecialchars(GWF_Session::getLastURL());
		return $this->_module->message('msg_shouted', array($url, $url));
	}
	
	public function isFlooding()
	{
		$uid = GWF_Session::getUserID();
		$uname = GWF_Shoutbox::generateUsername();
		$euname = GDO::escape($uname);
		$table = GDO::table('GWF_Shoutbox');
		
		$max = $uid === 0 ? $this->_module->cfgMaxPerDayGuest() : $this->_module->cfgMaxPerDayUser();
//		$cut = GWF_Time::getDate(GWF_Time::LEN_SECOND, time()-$this->_module->cfgTimeout());
//		$cnt = $table->countRows("shout_uname='$euname' AND shout_date>'$cut'");
		
		# Check captcha
		if ($this->_module->cfgCaptcha()) {
			require_once GWF_CORE_PATH.'inc/3p/Class_Captcha.php';
			if (!PhpCaptcha::Validate(Common::getPostString('captcha'), true)) {
				return GWF_HTML::err('ERR_WRONG_CAPTCHA');
			}
		}
		
		# Check date
		$timeout = $this->_module->cfgTimeout();
		$last_date = $table->selectVar('MAX(shout_date)', "shout_uid=$uid AND shout_uname='$euname'");
		$last_time = $last_date === NULL ? 0 : GWF_Time::getTimestamp($last_date);
		$next_time = $last_time+$timeout;
		if ($last_time+$timeout > time()) {
			return $this->_module->error('err_flood_time', array(GWF_Time::humanDuration($next_time - time())));
		}
		
		# Check amount
		$today = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$timeout);
		$count = $table->countRows("shout_uid=$uid AND shout_date>='$today'");
		if ($count >= $max) {
			return $this->_module->error('err_flood_limit', array($max));
		}
		
		# All fine
		return false;
	}
	
	public function validate_message(Module_Shoutbox $module, $message)
	{
		return GWF_Validator::validateString($this->_module, 'message', $message, 1, $this->_module->cfgMaxlen(), true);
	}
	
	########################
	### EMail Moderation ###
	########################
	public function onEMailModeration(Module_Shoutbox $module, $user, GWF_Shoutbox $entry)
	{
		foreach (GWF_UserSelect::getUsers(GWF_Group::STAFF) as $staff)
		{
			$this->onEMailModerationB($this->_module, $user, $entry, new GWF_User($staff));
		}
	}

	private function onEMailModerationB(Module_Shoutbox $module, $user, GWF_Shoutbox $entry, GWF_User $staff)
	{
		if ('' === ($rec = $staff->getValidMail()))
		{
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($this->_module->langUser($staff, 'emod_subj'));
		$id = $entry->getID();
		$token = $entry->getHashcode();
		$deletion_url = Common::getAbsoluteURL("index.php?mo=Shoutbox&me=Moderate&shoutid={$id}&token={$token}");
		$deletion_link = GWF_HTML::anchor($deletion_url, $deletion_url);
		$message = $entry->display('shout_message');
		$username = $user === false ? GWF_HTML::lang('guest') : $user->display('user_name');
		$mail->setBody($this->_module->langUser($staff, 'emod_body', array($username, $message, $deletion_link)));
		return $mail->sendToUser($staff);
	}
}
?>