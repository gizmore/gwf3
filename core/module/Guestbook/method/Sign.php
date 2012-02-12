<?php

final class Guestbook_Sign extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^guestbook/sign/(\d+)$ index.php?mo=Guestbook&me=Sign&gbid=$1'.PHP_EOL.
			'RewriteRule ^guestbook/sign/(\d+)/in/reply/to/(\d+)$ index.php?mo=Guestbook&me=Sign&gbid=$1&msgid=$2'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($gb = GWF_Guestbook::getByID(Common::getGet('gbid')))) {
			return $this->module->error('err_gb');
		}
		
		if (!$gb->canSign(GWF_Session::getUser(), $this->module->cfgAllowGuest())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}

		# In Reply To
		if (false !== ($msgid = Common::getGet('msgid')))
		{
			if (false === ($gbe = GWF_GuestbookMSG::getByID($msgid))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			if ($gbe->getVar('gbm_gbid') !== $gb->getID()) {
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
			if (false !== Common::getPost('sign')) {
				return $this->onSign($gb, $gbe);
			}
			return $this->templateReply($gb, $gbe);
		}
		

		if (false !== Common::getPost('sign')) {
			return $this->onSign($gb);
		}
		
		return $this->templateSign($gb);
	}
	
	private function templateReply(GWF_Guestbook $gb, GWF_GuestbookMSG $gbe)
	{
		$form = $this->getForm($gb, $gbe);
		$tVars = array(
			'in_reply' => $gbe,
			'form' => $form->templateY($this->module->lang('ft_sign', array( $gb->displayTitle()))),
		);
		return $this->module->template('sign.tpl', $tVars);
	}
	
	private function getForm(GWF_Guestbook $gb, $gbe=false)
	{
		$data = array();
		
		$user = GWF_Session::getUser();
		
		if ($user === false) {
			$data['username'] = array(GWF_Form::STRING, '', $this->module->lang('th_gbm_username'));
		}
		
		if ($gb->isEMailAllowed() && $this->module->cfgAllowEMail()) {
			$email = $user === false ? '' : $user->getValidMail();
			$data['email'] = array(GWF_Form::STRING, $email, $this->module->lang('th_gbm_email'), $this->module->lang('tt_gbm_email'), 32, false);
		}

		if ($gb->isURLAllowed() && $this->module->cfgAllowURL()) {
			$data['url'] = array(GWF_Form::STRING, '', $this->module->lang('th_gbm_url'));
		}
		
		$msg = $gbe === false ? '' : $gbe->getVar('gbm_message');
		
		$data['message'] = array(GWF_Form::MESSAGE, $msg, $this->module->lang('th_gbm_message'));
		
		if ($user === false && $this->module->cfgGuestCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		
		$data['showmail'] = array(GWF_Form::CHECKBOX, true, $this->module->lang('th_opt_showmail'));
		$data['public'] = array(GWF_Form::CHECKBOX, true, $this->module->lang('th_opt_public'));
		$data['toggle'] = array(GWF_Form::CHECKBOX, true, $this->module->lang('th_opt_toggle'));
		
		$data['sign'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_sign', array( $gb->displayTitle())));
		
		return new GWF_Form($this, $data);
	}

	private function templateSign(GWF_Guestbook $gb)
	{
		$form = $this->getForm($gb);
		$tVars = array(
			'can_mod' => $gb->canModerate(GWF_Session::getUser()),
			'form' => $form->templateY($this->module->lang('ft_sign', array( $gb->displayTitle()))),
		);
		return $this->module->templatePHP('sign.php', $tVars);
	}

	private function onSign(GWF_Guestbook $gb, $gbe=false)
	{
		$form = $this->getForm($gb);
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateSign($gb);
		}
		
		if ($gb->isLocked()) {
			return $this->module->error('err_locked');
		}
		
		if (false === ($user = GWF_Session::getUser())) {
			$userid = 0;
			$username = 'G#'.$form->getVar('username');
		}
		else {
			$userid = $user->getVar('user_id');
			$username = $user->getVar('user_name');
		}
		
		$options = 0;
		$options |= isset($_POST['showmail']) ? GWF_GuestbookMSG::SHOW_EMAIL : 0;
		$options |= isset($_POST['public']) ? GWF_GuestbookMSG::SHOW_PUBLIC : 0;
		$options |= isset($_POST['toggle']) ? GWF_GuestbookMSG::ALLOW_PUBLIC_TOGGLE : 0;
		$options |= $gb->isModerated() ? GWF_GuestbookMSG::IN_MODERATION : 0;
		
		$gbm = new GWF_GuestbookMSG(array(
			'gbm_gbid' => $gb->getID(),
			'gbm_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'gbm_username' => $username,
			'gbm_uid' => $userid,
			'gbm_url' => Common::getPost('url', ''),
			'gbm_email' => Common::getPost('email', ''),
			'gbm_options' => $options,
			'gbm_message' => Common::getPost('message', ''),
			'gbm_replyto' => $gbe === false ? 0 : $gbe->getID(),
		));

		if (false === $gbm->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateSign($gb);
		}
		
		$mod_append = $gb->isModerated() ? '_mod' : '';
		
		if ($gb->isModerated()) {
			$this->sendEmailModerate($gb, $gbm);
		} elseif ($gb->isEMailOnSign()) {
			$this->sendEmailSign($gb, $gbm);
		}
		
		return $this->module->message('msg_signed'.$mod_append).$this->module->requestMethodB('Show');
	}
	
	##################
	### Send EMail ###
	##################
	private function sendEmailModerate(GWF_Guestbook $gb, GWF_GuestbookMSG $gbm)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		
		$owner = $gb->getUser();
		if ( ($owner===false) || ('' === ($rec = $owner->getValidMail())) ) {
			$rec = GWF_ADMIN_EMAIL;
			$cc = GWF_STAFF_EMAILS;
			$recname = 'Staff';
		}
		else {
			$cc = '';
			$recname = $owner->displayUsername();
		}
		$mail->setReceiver($rec);
		$mail->setSubject($this->module->langAdmin('mails_signed'));
		
		$link = Common::getAbsoluteURL('index.php?mo=Guestbook&me=Unlock&set_moderation=0&gbid='.$gb->getID().'&gbmid='.$gbm->getID().'&gbmtoken='.$gbm->getHashcode());
		$link = GWF_HTML::anchor($link, $link);
		
		$mail->setBody($this->module->langAdmin('mailb_signed', array($recname, $gb->displayTitle(), $gbm->displayUsername(), $gbm->displayEMail(true), $gbm->display('gbm_message'), $link)));

		if ($owner === false) {
			$mail->sendAsHTML($cc);
		}
		else {
			$mail->sendToUser($owner);
		}
	}
	
	#########################
	### Send EMail Member ###
	#########################
	private function sendEmailSign(GWF_Guestbook $gb, GWF_GuestbookMSG $gbm)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		
		$owner = $gb->getUser();
		if ( ($owner===false) || ('' === ($rec = $owner->getValidMail())) ) {
			$rec = GWF_ADMIN_EMAIL;
			$cc = GWF_STAFF_EMAILS;
			$recname = 'Staff';
		}
		else {
			$cc = '';
			$recname = $owner->displayUsername();
		}
		$mail->setReceiver($rec);
		$mail->setSubject($this->module->langAdmin('mails2_signed'));
		
		$mail->setBody($this->module->langAdmin('mailb2_signed', array($recname, $gb->displayTitle(), $gbm->displayUsername(), $gbm->displayEMail(true), $gbm->display('gbm_message'))));
		
		if ($owner === false) {
			$mail->sendAsHTML($cc);
		}
		else {
			$mail->sendToUser($owner);
		}
	}
	
	##################
	### Validators ###
	##################
	public function validate_username(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['username'] = trim($arg);
		$max = $m->cfgMaxUsernameLen();
		$len = GWF_String::strlen($arg);
		if ($len < 1 || $len > $max) {
			return $m->lang('err_gbm_username', array(1, $max));
		}
		return false;
	}

	public function validate_email(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['email'] = trim($arg);
		if ($arg === '') {
			return false;
		}
		return GWF_Validator::isValidEmail($arg) ? false :$m->lang('err_gbm_email');
	}
	
	public function validate_url(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['url'] = trim($arg);
		if ($arg === '') {
			return false;
		}
		if (!GWF_Validator::isValidURL($arg)) {
			return $m->lang('err_gbm_url');
		}
		if (!GWF_HTTP::pageExists($arg)) {
			return $m->lang('err_gbm_url');
		}
		return false; 
	}
	
	public function validate_message(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['message'] = trim($arg);
		$len = GWF_String::strlen($arg);
		$max = $m->cfgMaxMessageLen();
		if ($len < 1 || $len > $max)
		{
			return $m->lang('err_gbm_message', array(1, $max));
		}
		return false;
	}
}

?>
