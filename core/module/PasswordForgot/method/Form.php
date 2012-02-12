<?php
/**
 * Request Password Forgotten Token.
 * Disabled when DEBUG_MAIL is on :)
 * @author gizmore
 */
final class PasswordForgot_Form extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^recovery$ index.php?mo=PasswordForgot&me=Form'.PHP_EOL;
//		$rewrites = array('recovery', 'passwort_vergessen', 'Dimenticati_il_Password');
//		return $this->getHTAccessMethods($rewrites);
	}
	
	public function execute()
	{
		if ((GWF_DEBUG_EMAIL&16)>0)
		{
			return GWF_HTML::err('ERR_MODULE_DISABLED', array( 'PasswordForgot'));
		}
		
		if (false !== (Common::getPost('request'))) {
			return $this->onRequest();
		}
		return $this->form();
	}
	
	private function getForm()
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $this->module->lang('th_username')),
			'email' => array(GWF_Form::STRING, '', $this->module->lang('th_email')),
		);
		if ($this->module->wantCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['request'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_request'), '');
		return new GWF_Form($this, $data);
	}
	
	private function form()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('title_request'))
		);
		return $this->module->templatePHP('request.php', $tVars);
	}
	
	public function validate_email(Module_PasswordForgot $module, $email) { return false; }
	public function validate_username(Module_PasswordForgot $module, $username) { return false; }
	
	private function onRequest()
	{
		$form = $this->getForm();
		
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->form();
		}
		
		$email = Common::getPost('email', '');
		
		$user1 = GWF_User::getByName(Common::getPost('username'));
		$user2 = GWF_Validator::isValidEmail($email) ? GWF_User::getByEmail($email) : false;

		# nothing found
		if ($user1 === false && $user2 === false) {
			return $this->module->error('err_not_found').$this->form();
		}
		
		# Two different users
		if ($user1 !== false && $user2 !== false && ($user1->getID() !== $user2->getID())) {
			return $this->module->error('err_not_same_user').$this->form();
		}

		# pick the user and send him mail
		if ($user1 !== false && $user2 !== false) {
			$user = $user1;
		}
		elseif ($user1 !== false) {
			$user = $user1;
		}
		elseif ($user2 !== false) {
			$user = $user2;
		}
		return $this->sendMail($user);
	}

	private function sendMail(GWF_User $user)
	{
		if ('' === ($email = $user->getValidMail()))
		{
			return $this->module->error('err_no_mail');
		}

		$sender = $this->module->getMailSender();
		$username = $user->displayUsername();
		$link = $this->getRequestLink($user);
		$body = $this->module->lang('mail_body', array( $username, $sender, $link));
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_SUPPORT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject($this->module->lang('mail_subj'));
		$mail->setBody($body);
		
		return $mail->sendToUser($user) ? $this->module->message('msg_sent_mail', array('<em>'.GWF_HTML::display(GWF_HTML::lang('unknown')).'</em>')) : GWF_HTML::err('ERR_MAIL_SENT'); 
	}
	
	private function getRequestLink(GWF_User $user)
	{
		$userid = $user->getID();
		
		require_once GWF_CORE_PATH.'module/Account/GWF_AccountChange.php';
		
		if (false === ($token = GWF_AccountChange::createToken($userid, 'pass'))) {
			return 'ERR';
		}
		$url = Common::getAbsoluteURL(sprintf('change_password/%d/%s', $userid, $token));
		return sprintf('<a href="%s">%s</a>', $url, $url);
	}
}

?>