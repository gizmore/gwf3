<?php

final class Admin_UserEdit extends GWF_Method
{
	/**
	 * @var GWF_User
	 */
	private $user;
	
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		$nav = $this->module->templateNav();
		
		if (false !== Common::getPost('edit')) {
			return $nav.$this->onEdit().$this->templateUserEdit();
		}
		
		return $nav.$this->templateUserEdit();
	}
	
	private function sanitize()
	{
		if (false === ($this->user = GWF_User::getByID(Common::getGet('uid')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return false;
	}
	
	private function getForm()
	{
		$u = $this->user;
		$data = array(
			# Basic
			'username' => array(GWF_Form::STRING, $u->displayUsername(), $this->module->lang('th_user_name')),
			'email' => array(GWF_Form::STRING, $u->display('user_email'), $this->module->lang('th_email')),
			'password' => array(GWF_Form::STRING, '', $this->module->lang('th_new_pass')),
			# Selects
			'gender' => array(GWF_Form::SELECT, $u->getGenderSelect('gender'), $this->module->lang('th_gender')),
			'country' => array(GWF_Form::SELECT, $u->getCountrySelect('country'), $this->module->lang('th_country')),
			'lang1' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'lang1', $u->getVar('user_langid')), $this->module->lang('th_lang_1')),
			'lang2' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'lang2', $u->getVar('user_langid2')), $this->module->lang('th_lang_2')),
			# Options
			'level' => array(GWF_Form::STRING, $u->getVar('user_level'), $this->module->lang('th_level')),
			'approved' => array(GWF_Form::CHECKBOX, $u->hasValidMail(), $this->module->lang('th_is_approved')),
			'bot' => array(GWF_Form::CHECKBOX, $u->isBot(), $this->module->lang('th_is_bot')),
			'online' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::HIDE_ONLINE), $this->module->lang('th_hide_online')),
			'showemail' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::SHOW_EMAIL), $this->module->lang('th_show_email')),
			'adult' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::WANTS_ADULT), $this->module->lang('th_want_adult')),
			'deleted' => array(GWF_Form::CHECKBOX, $u->isDeleted(), $this->module->lang('th_deleted')),
			# Action
			'edit' => array(GWF_Form::SUBMIT, $this->module->lang('btn_edit_user'), ''),
		);
		return new GWF_Form($this, $data);
	}

	private function templateUserEdit()
	{
		$u = $this->user;
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_useredit', array( $u->displayUsername()))),
			'href_login_as' => Module_Admin::getLoginAsURL($u->urlencode('user_name')),
			'href_user_groups' => GWF_WEB_ROOT.'index.php?mo=Admin&me=UserGroup&uid='.$u->getID(),
			'user' => $u,
		);
		return $this->module->templatePHP('user_edit.php', $tVars);
	}

	##################
	### Validators ###
	##################	
	public function validate_username(Module_Admin $module, $arg)
	{
		$_POST['username'] = $arg = trim($arg);
		
		if ($this->user->getVar('user_name') === $arg)
		{
			return false;
		}
		
		if (GWF_User::getByName($arg) !== false)
		{
			return $this->module->lang('err_username_taken');
		}
		
		if (!GWF_Validator::isValidUsername($arg))
		{
			return $this->module->lang('err_username');
		}
		
		return false;
	}
	
	public function validate_level($m, $arg)
	{
		return GWF_Validator::validateInt($m, 'level', $arg, '-2000000000', '2000000000', true);
	}
	
	public function validate_email(Module_Admin $module, $arg)
	{
		$arg = trim($arg);
		$_POST['email'] = $arg;
		return GWF_Validator::isValidEmail($arg) ? false : $this->module->lang('err_email');
	}
	
	public function validate_password(Module_Admin $module, $arg) { return false; }
	public function validate_gender(Module_Admin $module, $arg) { return GWF_Gender::isValidGender($arg) ? false : $this->module->lang('err_gender'); }
	public function validate_country(Module_Admin $module, $arg) { return GWF_CountrySelect::validate_countryid($arg, true); }
	public function validate_lang1(Module_Admin $module, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_lang2(Module_Admin $module, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	
	###############
	### On Edit ###
	###############
	private function onEdit()
	{
		$u = $this->user;
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		if ($form->getVar('email') !== $u->getVar('user_email'))
		{
			GWF_Hook::call(GWF_Hook::CHANGE_MAIL, $u, array($u->getVar('user_email'), $form->getVar('email')));
		}
		
		if (false === $u->saveVars(array(
			'user_countryid' => $form->getVar('country'),
			'user_langid' => $form->getVar('lang1'),
			'user_langid2' => $form->getVar('lang2'),
			'user_gender' => $form->getVar('gender'),
			'user_email' => $form->getVar('email'),
			'user_level' => $form->getVar('level'),
		))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$msgs = array_merge(
			$this->onEditFlags('bot', $u->isBot(), GWF_User::BOT),
			$this->onEditFlags('showemail', $u->isOptionEnabled(GWF_User::SHOW_EMAIL), GWF_User::SHOW_EMAIL),
			$this->onEditFlags('adult', $u->isOptionEnabled(GWF_User::WANTS_ADULT), GWF_User::WANTS_ADULT),
			$this->onEditFlags('online', $u->isOptionEnabled(GWF_User::HIDE_ONLINE), GWF_User::HIDE_ONLINE),
			$this->onEditFlags('approved', $u->hasValidMail(), GWF_User::MAIL_APPROVED),
			$this->onEditDeleteFlag($u->isDeleted(), Common::getPost('deleted') !== false),
			$this->onEditUsername($u->getVar('user_name'), $form->getVar('username')),
			$this->onEditPassword($form->getVar('password'))
		);

		$msgs[] = $this->module->lang('msg_user_edited');
		
		return GWF_HTML::messageA('Account', $msgs);
	}
	
	private function onEditFlags($key, $oldFlag, $bits)
	{
		$newFlag = Common::getPost($key) !== false;
		if ($newFlag === $oldFlag) {
			return array();
		}
		if (false === $this->user->saveOption($bits, $newFlag)) {
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return array();
		}
		$key = sprintf('msg_%s_%s', $key, $newFlag === true ? '1' : '0');
		return array($this->module->lang($key));
	}
	
	private function onEditDeleteFlag($oldFlag, $newFlag)
	{
		$u = $this->user;
		if ($oldFlag === $newFlag) {
			return array();
		}
		
		if (false === $u->saveOption(GWF_User::DELETED, $newFlag)) {
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return array();
		}

		GWF_Hook::call(GWF_Hook::DELETE_USER, $u);
		
		if ($newFlag)
		{
			$uid = $this->user->getID();
			GDO::table('GWF_Session')->deleteWhere('sess_user='.$uid);
		}
		
		$key = $newFlag === true ? 'msg_deleted' : 'msg_undeleted';
		return array($this->module->lang($key));
	}
	
	private function onEditUsername($oldName, $newName)
	{
		$u = $this->user;
		if ($oldName === $newName) {
			return array();
		}
		
		if (false === GWF_Hook::call(GWF_Hook::CHANGE_UNAME, $u, array($newName))) {
			return array(GWF_HTML::err('ERR_HOOK', array( 'Change UNAME')));
		}
		
		if (false === $u->saveVar('user_name', $newName)) {
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return array();
		}
		
		return array($this->module->lang('msg_username_changed', array(GWF_HTML::display($oldName), GWF_HTML::display($newName))));
	}
	
	private function onEditPassword($newpass)
	{
		$user = $this->user;
		
		if ($newpass === '') {
			return array();
		}
		
		unset($_POST['password']); 
		
		if (false === $user->saveVar('user_password' , GWF_Password::hashPasswordS($newpass))) {
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return array();
		}
		
		GWF_Hook::call(GWF_Hook::CHANGE_PASSWD, $user, array($newpass, ''));
		
		return array($this->module->lang('msg_userpass_changed', array( $user->displayUsername(), GWF_HTML::display($newpass))));
	}
	
} 

?>
