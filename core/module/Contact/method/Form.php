<?php
/**
 * Contact form
 * @author gizmore
 */
final class Contact_Form extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^contact/?$ index.php?mo=Contact&me=Form'.PHP_EOL;
	}

	public function execute()
	{
		GWF_Website::setPageTitle($this->module->lang('page_title'));
		GWF_Website::setMetaTags($this->module->lang('page_meta'));
		if (false !== (Common::getPost('contact')))
		{
			return $this->onSend();
		}
		return $this->templateForm();
	}

	public function validate_email(GWF_Module $module, $arg)
	{
		if ($arg === '') {
			return false;
		}
		return GWF_Validator::isValidEmail($arg) ? false : $this->module->lang('err_email');
	}

	public function validate_message(GWF_Module $module, $arg)
	{
		return strlen($arg) < 5 ? $this->module->lang('err_message') : false;
	}

	private function getForm()
	{
		$user = GWF_Session::getUser();
		$default_email = $user === false ? '' : $user->getVar('user_email');
		$data = array(
			'email' => array(GWF_Form::STRING, $default_email, $this->module->lang('th_email')),
			'message' => array(GWF_Form::MESSAGE, '', $this->module->lang('th_message')),
		);
		if ($this->module->isCaptchaEnabled()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['contact'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_contact'), '');

		return new GWF_Form($this, $data);
	}

	private function templateForm()
	{
		$form = $this->getForm();
		$skype = $this->module->getContactSkype();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('form_title')),
			'email' => $this->module->getContactEMail(),
			'skype' => $skype === '' ? '' : $this->module->lang('info_skype', array( $skype)),
			'admin_profiles' => $this->getAdminProfiles(),
		);
		return $this->module->template('form.tpl', $tVars);
	}

	private function getAdminProfiles()
	{
        $admin = GWF_Group::getByName('admin')->getID();
        $staff = GWF_Group::getByName('staff')->getID();
		$u = GWF_TABLE_PREFIX.'user';
		$ug = GWF_TABLE_PREFIX.'usergroup';
		$db = gdo_db();
		$query = "SELECT DISTINCT user_name FROM {$ug} AS ug INNER JOIN {$u} AS u ON u.user_id=ug_userid WHERE ug_groupid={$admin} OR ug_groupid={$staff}";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}
		$back = '';
		while (false !== ($row = $db->fetchRow($result)))
		{
			$name = $row[0];
			$back .= sprintf(', <a href="%s">%s</a>', GWF_WEB_ROOT.'profile/'.urlencode($name), GWF_HTML::display($name));
		}
		$db->free($result);
		return substr($back, 2);
	}

	private function onSend()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateForm();
		}

		return $this->onSendB($form->getVar('email'), $form->getVar('message'));
	}
	
	private function onSendB($email, $message)
	{
		$admin = GWF_Group::ADMIN;
		if (false === ($adminids = GDO::table('GWF_UserGroup')->selectColumn('ug_userid', "group_name='{$admin}'", '', array('group')))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$send_to = array();
		foreach ($adminids as $userid)
		{
			if (false === ($user = GWF_User::getByID($userid))) {
				continue;
			}
			if (false === ($user->hasValidMail())) {
				continue;
			}
			if (false === $this->onSendC($email, $message, $user)) {
				continue;
			}
			$send_to[] = $user->displayUsername();
		}

		return $send_to === '' ? GWF_HTML::err('ERR_MAIL_SENT') : $this->module->message('msg_mailed', array(GWF_Array::implodeHuman($send_to)));
	}

	private function onSendC($email, $message, GWF_User $user)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setReply($email);
		$mail->setSubject($this->module->langUser($user, 'mail_subj'));
		$mail->setBody($this->module->langUser($user, 'mail_body', array($email, $message)));
		return $mail->sendToUser($user);
	}
}
