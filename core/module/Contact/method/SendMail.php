<?php
/**
 * Send email to an arbitary user.
 * @author gizmore
 */
final class Contact_SendMail extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^send/email/to/([^/]+)$ index.php?mo=Contact&me=SendMail&username=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($user = GWF_User::getByName(Common::getGet('username')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if ('' === ($email = $user->getValidMail()) || (!$user->isOptionEnabled(GWF_User::ALLOW_EMAIL))) {
			return $this->module->error('err_no_mail');
		}
		
		if (false !== Common::getPost('send')) {
			return $this->send($user);
		}
		
		return $this->template($user);
	}
	
	private function template(GWF_User $user)
	{
		$form = $this->form($user);
		$tVars = array(
//			'href_mailto' => sprintf('mailto:'.$user->getValidMail()),
			'form' => $form->templateY($this->module->lang('ft_sendmail', array( $user->displayUsername()))),
//			'' => '',
		);
		return $this->module->template('sendmail.tpl', $tVars);
	}
	
	private function send(GWF_User $user)
	{
		$form = $this->form($user);
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->template($user);
		}
		
		$u = GWF_User::getStaticOrGuest();
		$sendermail = $u->getValidMail();
		if ($sendermail === '') { $sendermail = Common::getPost('email'); }
		if ($sendermail === '') { $sendermail = GWF_HTML::lang('unknown'); }
		$sendermail = GWF_HTML::display($sendermail);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setSubject($this->module->langUser($user, 'mail_subj_mail', $sendermail));
		$mail->setBody($this->module->langUser($user, 'mail_subj_body', array($user->displayUsername(), $sendermail, GWF_Message::display($_POST['message']))));
		if (false === $mail->sendToUser($u)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		return $this->module->message('msg_mailed', array($user->displayUsername()));
	}

	public function validate_email(Module_Contact $m, $arg) { return GWF_Validator::validateEMail($m, 'email', $arg, true, true); }
	public function validate_message(Module_Contact $m, $arg) { return GWF_Validator::validateString($m, 'message', $arg, 16, $m->cfgMaxMsgLen(), false); }
	private function form(GWF_User $user)
	{
		$u = GWF_User::getStaticOrGuest();
		
		$data = array();
		
		if ('' === ($email = $u->getValidMail())) {
			$data['email'] = array(GWF_Form::STRING, $u->getValidMail(), $this->module->lang('th_user_email'));
		}

		$data['message'] = array(GWF_Form::MESSAGE, '', $this->module->lang('th_message'));
		if ($u->getID() === '0')
		{
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['send'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_sendmail'));
		
		return new GWF_Form($this, $data);
	}
}

?>