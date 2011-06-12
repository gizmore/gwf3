<?php
/**
 * Request Password Forgotten Token.
 * Disabled when DEBUG_MAIL is on :)
 * @author gizmore
 */
final class PasswordForgot_Form extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^recovery$ index.php?mo=PasswordForgot&me=Form'.PHP_EOL;
//		$rewrites = array('recovery', 'passwort_vergessen', 'Dimenticati_il_Password');
//		return $this->getHTAccessMethods($module, $rewrites);
	}
	
	public function execute(GWF_Module $module)
	{
		if (GWF_IP6::isLocal())
		{
			return GWF_HTML::err('ERR_MODULE_DISABLED', array( 'PasswordForgot'));
		}
		
		if (false !== (Common::getPost('request'))) {
			return $this->onRequest($module);
		}
		return $this->form($module);
	}
	
	private function getForm(Module_PasswordForgot $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $module->lang('th_username'), 20),
			'email' => array(GWF_Form::STRING, '', $module->lang('th_email'), 20),
		);
		if ($module->wantCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['request'] = array(GWF_Form::SUBMIT, $module->lang('btn_request'), '');
		return new GWF_Form($this, $data);
	}
	
	private function form(Module_PasswordForgot $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('title_request'))
		);
		return $module->templatePHP('request.php', $tVars);
	}
	
	public function validate_email(Module_PasswordForgot $module, $email) { return false; }
	public function validate_username(Module_PasswordForgot $module, $username) { return false; }
	
	private function onRequest(Module_PasswordForgot $module)
	{
		$form = $this->getForm($module);
		
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->form($module);
		}
		
		$email = Common::getPost('email', '');
		
		$user1 = GWF_User::getByName(Common::getPost('username'));
		$user2 = GWF_Validator::isValidEmail($email) ? GWF_User::getByEmail($email) : false;

		# nothing found
		if ($user1 === false && $user2 === false) {
			return $module->error('err_not_found').$this->form($module);
		}
		
		# Two different users
		if ($user1 !== false && $user2 !== false && ($user1->getID() !== $user2->getID())) {
			return $module->error('err_not_same_user').$this->form($module);
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
		return $this->sendMail($module, $user);
	}

	private function sendMail(Module_PasswordForgot $module, GWF_User $user)
	{
		if (!$user->hasValidMail()) {
			return $module->error('err_no_mail');
		}

		$sender = $module->getMailSender();
		$email = $user->getEmail();
		$username = $user->displayUsername();
		$link = $this->getRequestLink($module, $user);
		$body = $module->lang('mail_body', array( $username, $sender, $link));
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_SUPPORT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject($module->lang('mail_subj'));
		$mail->setBody($body);
		
		return $mail->sendToUser($user) ? $module->message('msg_sent_mail', array('<em>'.GWF_HTML::display(GWF_HTML::lang('unknown')).'</em>')) : GWF_HTML::err('ERR_MAIL_SENT'); 
	}
	
	private function getRequestLink(Module_PasswordForgot $module, GWF_User $user)
	{
		$userid = $user->getID();
		
		require_once 'module/Account/GWF_AccountChange.php';
		
		if (false === ($token = GWF_AccountChange::createToken($userid, 'pass'))) {
			return 'ERR';
		}
		$url = Common::getAbsoluteURL(sprintf('change_password/%d/%s', $userid, $token));
		return sprintf('<a href="%s">%s</a>', $url, $url);
	}
}

?>