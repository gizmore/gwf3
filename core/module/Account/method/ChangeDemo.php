<?php
final class Account_ChangeDemo extends GWF_Method
{
	public function execute()
	{
		if (false !== ($token = Common::getGet('token'))) {
			return $this->onChange($token);
		}
	}
	
	public static function requestChange(Module_Account $module, GWF_User $user, array $data)
	{
		if (true !== ($error = self::mayChange($module, $user))) {
			$_POST = array();
			return $error;
		}
		
		if ($module->cfgUseEmail() && $user->hasValidMail())
		{
			return self::sendMail($module, $user, $data);
		}
		else
		{
			unset($_POST['change']);
			return self::change($module, $user, $data);
		}
	}
	
	private static function mayChange(Module_Account $module, GWF_User $user)
	{
		if (false !== ($row = GWF_AccountChange::getACRow($user->getID(), 'demo_lock')))
		{
			$last = $row->getVar('timestamp');
			$elapsed = time() - $last;
			$min_wait = $module->cfgChangeTime();
			if ($elapsed < $min_wait)
			{
				$wait = $min_wait - $elapsed;
				return $module->error('err_demo_wait', array(GWF_Time::humanDuration($wait)));
			}
		}
		return true;
	}
	
	public static function change(Module_Account $module, GWF_User $user, array $data)
	{
		if (false === $user->saveVars($data)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		GWF_AccountChange::createToken($user->getID(), 'demo_lock');
		
		return $module->message('msg_demo_changed');
	}
	
	private static function sendMail(Module_Account $module, GWF_User $user, array $data)
	{
		$token = GWF_AccountChange::createToken($user->getID(), 'demo', serialize($data));
		
		$mail = new GWF_Mail();
		$mail->setSender($module->cfgMailSender());
		$mail->setReceiver($user->getVar('user_email'));
		$mail->setSubject($module->lang('chdemo_subj'));
		
		$username = $user->display('user_name');
		$timeout = GWF_Time::humanDuration($module->cfgChangeTime());
		
		$gender = GWF_HTML::display($user->getVar('user_gender'));
		$country = GWF_Country::getByIDOrUnknown($data['user_countryid'])->display('country_name');
		$lang1 = GWF_Language::getByIDOrUnknown($data['user_langid'])->display('lang_nativename');
		$lang2 = GWF_Language::getByIDOrUnknown($data['user_langid2'])->display('lang_nativename');
		$gender = GWF_HTML::lang('gender_'.$data['user_gender']);
		
		$birthdate = $data['user_birthdate'] > 0 ? GWF_Time::displayDate($data['user_birthdate'], true, 1) : GWF_HTML::lang('unknown');
		$link = self::getChangeLink($user->getID(), $token);
		$mail->setBody($module->lang('chdemo_body', array( $username, $timeout, $gender, $country, $lang1, $lang2, $birthdate, $link)));
		
		return $mail->sendToUser($user) ? $module->message('msg_mail_sent') : GWF_HTML::err('ERR_MAIL_SENT');
	}
	
	private static function getChangeLink($userid, $token)
	{
		$url = Common::getAbsoluteURL(sprintf('index.php?mo=Account&me=ChangeDemo&userid=%s&token=%s', $userid, $token));
		return GWF_HTML::anchor($url, $url);
	}
	
	private function onChange($token)
	{
		$userid = (int) Common::getGet('userid');
		if (false === ($ac = GWF_AccountChange::checkToken($userid, $token, 'demo'))) {
			return $this->module->error('err_token');
		}
		if (false === ($user = GWF_User::getByID($userid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === ($data = @unserialize($ac->getVar('data')))) {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false === $user->saveVars($data)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $ac->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		GWF_AccountChange::createToken($userid, 'demo_lock');
		
		return $this->module->message('msg_demo_changed');
	}
}

?>
