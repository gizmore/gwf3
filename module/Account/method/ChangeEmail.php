<?php

final class Account_ChangeEmail extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('changemail'))) {
			return $this->onRequestB($module);
		}
		
		if (false !== ($token = Common::getGet('token'))) {
			return $this->onChangeA($module, $token);
		}

		if (false !== ($token = Common::getGet('change'))) {
			return $this->onChangeB($module, $token);
		}
	}
	
	public static function changeEmail(Module_Account $module, GWF_User $user, $newMail)
	{
		if ($module->cfgUseEmail() && $user->hasValidMail())
		{
			return self::sendEmail($module, $user, $newMail);
		}
		else
		{
			return self::sendEmailB($module, $user->getID(), $newMail);
		}
	}
	
	private static function sendEmail(Module_Account $module, GWF_User $user, $newMail)
	{
		$mail = new GWF_Mail();
		$mail->setReceiver($user->getVar('user_email'));
		$mail->setSender($module->cfgMailSender());
		$mail->setSubject($module->lang('chmaila_subj'));
		$newmail = trim(Common::getPost('email'));
		$link = self::createLink($module, $user, $newMail);
		$mail->setBody($module->lang('chmaila_body', array( $user->display('user_name'), $link)));
		
		if ($mail->sendToUser($user)) {
			return $module->message('msg_mail_sent');
		} else {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
	}
	
	private static function createLink(Module_Account $module, GWF_User $user, $newMail)
	{
		$token = GWF_AccountChange::createToken($user->getID(), 'email', $newMail);
		$url = Common::getAbsoluteURL(sprintf('index.php?mo=Account&me=ChangeEmail&userid=%s&token=%s', $user->getID(), $token));
		return sprintf('<a href="%s">%s</a>', $url, $url);
	}
	
	private function onChangeA(Module_Account $module, $token)
	{
		$userid = (int) Common::getGet('userid');
		if (false === ($row = GWF_AccountChange::checkToken($userid, $token, 'email'))) {
			return $module->error('err_token_chmaila');
		}
		
		return $this->templateChangeMailB($module, $row);
	}
	
	private function getChangeMailForm(Module_Account $module, GWF_AccountChange $ac)
	{
		$data = array(
			'email' => array(GWF_Form::STRING, '', $module->lang('th_email_new'), 48, '', '', true),
			'email_re' => array(GWF_Form::STRING, '', $module->lang('th_email_re'), 48, '', '', true),
			'changemail' => array(GWF_Form::SUBMIT, $module->lang('btn_changemail')),
			'token' => array(GWF_Form::HIDDEN, $ac->getVar('token')),
			'userid' => array(GWF_Form::HIDDEN, $ac->getVar('userid')),
		);
		return new GWF_Form('GWF_User', $data);	
	}
	
	private function templateChangeMailB(Module_Account $module, GWF_AccountChange $ac)
	{
		$form = $this->getChangeMailForm($module, $ac);
		
		$tVars = array(
			'form' => $form->templateY($module->lang('chmail_title')),
		);
		return $module->templatePHP('changemail.php', $tVars);
	}
	
	private function onRequestB(Module_Account $module)
	{
		$token = Common::getPost('token');
		$userid = (int) Common::getPost('userid');
		if (false === ($row = GWF_AccountChange::checkToken($userid, $token, 'email'))) {
			return $module->error('err_token');
		}
		
		$email1 = Common::getPost('email');
		$email2 = Common::getPost('email_re');
		if (!GWF_Validator::isValidEmail($email1)) {
			return GWF_HTML::err('ERR_INVALID_EMAIL').$this->templateChangeMailB($module, $row);
		}
		
		if ($email1 !== $email2) {
			return $module->error('err_email_retype').$this->templateChangeMailB($module, $row);
		}
		
		if (GWF_User::getByEmail($email1) !== false) {
			return GWF_HTML::err('ERR_EMAIL_TAKEN');
		}
		
		if (false === $row->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return self::sendEmailB($module, $userid, $email1);
	}
	
	private static function sendEmailB(Module_Account $module, $userid, $email)
	{
		$token = GWF_AccountChange::createToken($userid, 'email2', $email);
		
		$mail = new GWF_Mail();
		$mail->setSender($module->cfgMailSender());
		$mail->setReceiver($email);
		$mail->setSubject($module->lang('chmailb_subj'));
		
		if (false === ($user = GWF_User::getByID($userid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$link = self::getLinkB($token, $userid);
		$body = $module->lang('chmailb_body', array( $user->display('user_name'), $link));
		$mail->setBody($body);

		if (!$mail->sendToUser($user)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		
		return $module->message('msg_mail_sent', array(htmlspecialchars($email)));
	}
	
	private static function getLinkB($token, $userid)
	{
		$url = Common::getAbsoluteURL(sprintf('index.php?mo=Account&me=ChangeEmail&userid=%s&change=%s', $userid, $token));
		return sprintf('<a href="%s">%s</a>', $url, $url);
	}

	private function onChangeB(Module_Account $module, $token)
	{
		$userid = (int) Common::getGet('userid');
		if (false === ($ac = GWF_AccountChange::checkToken($userid, $token, 'email2'))) {
			return $module->error('err_token');
		}
		
		if (false === ($user = $ac->getUser())) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === $ac->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$newmail = $ac->getVar('data');
		
		$user->saveVar('user_email', $newmail);
		$user->saveOption(GWF_User::MAIL_APPROVED, true);
		
		return $module->message('msg_mail_changed', array(htmlspecialchars($newmail)));
	}
}

?>