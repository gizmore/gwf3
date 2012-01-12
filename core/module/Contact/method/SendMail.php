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
			return $this->_module->error('err_no_mail');
		}
		
		if (false !== Common::getPost('send')) {
			return $this->send($this->_module, $user);
		}
		
		return $this->template($this->_module, $user);
	}
	
	private function template(Module_Contact $module, GWF_User $user)
	{
		$form = $this->form($this->_module, $user);
		$tVars = array(
//			'href_mailto' => sprintf('mailto:'.$user->getValidMail()),
			'form' => $form->templateY($this->_module->lang('ft_sendmail', array( $user->displayUsername()))),
//			'' => '',
		);
		return $this->_module->template('sendmail.tpl', $tVars);
	}
	
	private function send(Module_Contact $module, GWF_User $user)
	{
		$form = $this->form($this->_module, $user);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->template($this->_module, $user);
		}
		
		$u = GWF_User::getStaticOrGuest();
		$sendermail = $u->getValidMail();
		if ($sendermail === '') { $sendermail = Common::getPost('email'); }
		if ($sendermail === '') { $sendermail = GWF_HTML::lang('unknown'); }
		$sendermail = GWF_HTML::display($sendermail);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setSubject($this->_module->langUser($user, 'mail_subj_mail', $sendermail));
		$mail->setBody($this->_module->langUser($user, 'mail_subj_body', array($user->displayUsername(), $sendermail, GWF_Message::display($_POST['message']))));
		if (false === $mail->sendToUser($u)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		return $this->_module->message('msg_mailed', array($user->displayUsername()));
	}

	public function validate_email(Module_Contact $m, $arg) { return GWF_Validator::validateEMail($m, 'email', $arg, true, true); }
	public function validate_message(Module_Contact $m, $arg) { return GWF_Validator::validateString($m, 'message', $arg, 16, $m->cfgMaxMsgLen(), false); }
	private function form(Module_Contact $module, GWF_User $user)
	{
		$u = GWF_User::getStaticOrGuest();
		
		$data = array();
		
		if ('' === ($email = $u->getValidMail())) {
			$data['email'] = array(GWF_Form::STRING, $u->getValidMail(), $this->_module->lang('th_user_email'));
		}

		$data['message'] = array(GWF_Form::MESSAGE, '', $this->_module->lang('th_message'));
		if ($u->getID() === 0) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['send'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_sendmail'));
		
		return new GWF_Form($this, $data);
	}
}

?>