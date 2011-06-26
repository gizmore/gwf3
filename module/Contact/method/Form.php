<?php
/**
 * Contact form
 * @author gizmore
 */
final class Contact_Form extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^contact/?$ index.php?mo=Contact&me=Form'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('page_title'));
		GWF_Website::setMetaTags($module->lang('page_meta'));
		if (false !== (Common::getPost('contact'))) {
			return $this->onSend($module);
		}
		return $this->templateForm($module);
	}

	public function validate_email(GWF_Module $module, $arg)
	{
		if ($arg === '') {
			return false;
		}
		return GWF_Validator::isValidEmail($arg) ? false : $module->lang('err_email');
	}

	public function validate_message(GWF_Module $module, $arg)
	{
		return strlen($arg) < 5 ? $module->lang('err_message') : false;
	}

	private function getForm(Module_Contact $module)
	{
		$user = GWF_Session::getUser();
		$default_email = $user === false ? '' : $user->getVar('user_email');
		$data = array(
			'email' => array(GWF_Form::STRING, $default_email, $module->lang('th_email'), 30),
			'message' => array(GWF_Form::MESSAGE, '', $module->lang('th_message')),
		);
		if ($module->isCaptchaEnabled()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['contact'] = array(GWF_Form::SUBMIT, $module->lang('btn_contact'), '');

		return new GWF_Form($this, $data);
	}

	private function templateForm(Module_Contact $module)
	{
		$form = $this->getForm($module);
		$skype = $module->getContactSkype();
		$tVars = array(
			'form' => $form->templateY($module->lang('form_title')),
			'email' => $module->getContactEMail(),
			'skype' => $skype === '' ? '' : $module->lang('info_skype', array( $skype)),
			'admin_profiles' => $this->getAdminProfiles($module),
		);
		return $module->template('form.tpl', $tVars);
	}

	private function getAdminProfiles(Module_Contact $module)
	{
		$admin = GWF_Group::getByName('admin')->getID();
		$u = GWF_TABLE_PREFIX.'user';
		$ug = GWF_TABLE_PREFIX.'usergroup';
		$db = gdo_db();
		$query = "SELECT user_name FROM $ug AS ug INNER JOIN $u AS u ON u.user_id=ug_userid WHERE ug_groupid=$admin";
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

	private function onSend(Module_Contact $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateForm($module);
		}

		return $this->onSendB($module, $form->getVar('email'), $form->getVar('message'));
	}
	
	private function onSendB(Module_Contact $module, $email, $message)
	{
		$admin = GWF_Group::ADMIN;
		if (false === ($adminids = GDO::table('GWF_UserGroup')->selectColumn('ug_userid', "group_name='$admin'", '', array('group')))) {
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
			if (false === $this->onSendC($module, $email, $message, $user)) {
				continue;
			}
			$send_to[] = $user->displayUsername();
		}
		
		return $send_to === '' ? GWF_HTML::err('ERR_MAIL_SENT') : $module->message('msg_mailed', array(Common::implodeHuman($send_to)));
	}
	
	private function onSendC(Module_Contact $module, $email, $message, GWF_User $user)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setSubject($module->langUser($user, 'mail_subj'));
		$mail->setBody($module->langUser($user, 'mail_body', array($email, $message)));
		return $mail->sendToUser($user);
	}
}

?>