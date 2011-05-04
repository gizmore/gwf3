<?php

final class Admin_UserEdit extends GWF_Method
{
	/**
	 * @var GWF_User
	 */
	private $user;
	
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		$nav = $module->templateNav();
		
		if (false !== Common::getPost('edit')) {
			return $nav.$this->onEdit($module).$this->templateUserEdit($module);
		}
		
		return $nav.$this->templateUserEdit($module);
	}
	
	private function sanitize(Module_Admin $module)
	{
		if (false === ($this->user = GWF_User::getByID(Common::getGet('uid')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return false;
	}
	
	private function getForm(Module_Admin $module)
	{
		$u = $this->user;
		$data = array(
			# Basic
			'username' => array(GWF_Form::STRING, $u->displayUsername(), $module->lang('th_user_name')),
			'email' => array(GWF_Form::STRING, $u->display('user_email'), $module->lang('th_email')),
			'password' => array(GWF_Form::STRING, '', $module->lang('th_new_pass')),
			# Selects
			'gender' => array(GWF_Form::SELECT, $u->getGenderSelect('gender'), $module->lang('th_gender')),
			'country' => array(GWF_Form::SELECT, $u->getCountrySelect('country'), $module->lang('th_country')),
			'lang1' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'lang1', $u->getVar('user_langid')), $module->lang('th_lang_1')),
			'lang2' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'lang2', $u->getVar('user_langid2')), $module->lang('th_lang_1')),
			# Options
			'level' => array(GWF_Form::STRING, $u->getVar('user_level'), $module->lang('th_level')),
			'approved' => array(GWF_Form::CHECKBOX, $u->hasValidMail(), $module->lang('th_is_approved')),
			'bot' => array(GWF_Form::CHECKBOX, $u->isBot(), $module->lang('th_is_bot')),
			'online' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::HIDE_ONLINE), $module->lang('th_hide_online')),
			'showemail' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::SHOW_EMAIL), $module->lang('th_show_email')),
			'adult' => array(GWF_Form::CHECKBOX, $u->isOptionEnabled(GWF_User::WANTS_ADULT), $module->lang('th_want_adult')),
			'deleted' => array(GWF_Form::CHECKBOX, $u->isDeleted(), $module->lang('th_deleted')),
			# Action
			'edit' => array(GWF_Form::SUBMIT, $module->lang('btn_edit_user'), ''),
		);
		return new GWF_Form($this, $data);
	}

	private function templateUserEdit(Module_Admin $module)
	{
		$u = $this->user;
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_useredit', array( $u->displayUsername()))),
			'href_login_as' => Module_Admin::getLoginAsURL($u->urlencode('user_name')),
			'href_user_groups' => GWF_WEB_ROOT.'index.php?mo=Admin&me=UserGroup&uid='.$u->getID(),
			'user' => $u,
		);
		return $module->templatePHP('user_edit.php', $tVars);
	}

	##################
	### Validators ###
	##################	
	public function validate_username(Module_Admin $module, $arg)
	{
		$arg = trim($arg);
		$_POST['username'] = $arg;
		if ($this->user->getVar('user_name') === $arg) {
			return false;
		}
		if (GWF_User::getByName($arg) !== false) {
			return $module->lang('err_username_taken');
		}
		if (!GWF_Validator::isValidUsername($arg)) {
			return $module->lang('err_username');
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
		return GWF_Validator::isValidEmail($arg) ? false : $module->lang('err_email');
	}
	
	public function validate_password(Module_Admin $module, $arg) { return false; }
	public function validate_gender(Module_Admin $module, $arg) { return GWF_Gender::isValidGender($arg) ? false : $module->lang('err_gender'); }
	public function validate_country(Module_Admin $module, $arg) { return GWF_CountrySelect::validate_countryid($arg, true); }
	public function validate_lang1(Module_Admin $module, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_lang2(Module_Admin $module, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	
	###############
	### On Edit ###
	###############
	private function onEdit(Module_Admin $module)
	{
		$u = $this->user;
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
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
			$this->onEditFlags($module, 'bot', $u->isBot(), GWF_User::BOT),
			$this->onEditFlags($module, 'showemail', $u->isOptionEnabled(GWF_User::SHOW_EMAIL), GWF_User::SHOW_EMAIL),
			$this->onEditFlags($module, 'adult', $u->isOptionEnabled(GWF_User::WANTS_ADULT), GWF_User::WANTS_ADULT),
			$this->onEditFlags($module, 'online', $u->isOptionEnabled(GWF_User::HIDE_ONLINE), GWF_User::HIDE_ONLINE),
			$this->onEditFlags($module, 'approved', $u->hasValidMail(), GWF_User::MAIL_APPROVED),
			$this->onEditDeleteFlag($module, $u->isDeleted(), Common::getPost('deleted') !== false),
			$this->onEditUsername($module, $u->getVar('user_name'), $form->getVar('username')),
			$this->onEditPassword($module, $form->getVar('password'))
		);

		$msgs[] = $module->lang('msg_user_edited');
		
		return GWF_HTML::messageA('Account', $msgs);
	}
	
	private function onEditFlags(Module_Admin $module, $key, $oldFlag, $bits)
	{
		$newFlag = Common::getPost($key) !== false;
		if ($newFlag === $oldFlag) {
			return array();
		}
		if (false === $this->user->saveOption($bits, $newFlag)) {
			GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
			return array();
		}
		$key = sprintf('msg_%s_%s', $key, $newFlag === true ? '1' : '0');
		return array($module->lang($key));
	}
	
	private function onEditDeleteFlag(Module_Admin $module, $oldFlag, $newFlag)
	{
		$u = $this->user;
		if ($oldFlag === $newFlag) {
			return array();
		}
		
		if (false === $u->saveOption(GWF_User::DELETED, $newFlag)) {
			GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
			return array();
		}

		GWF_Hook::call(GWF_Hook::DELETE_USER, $u);
		
		$key = $newFlag === true ? 'msg_deleted' : 'msg_undeleted';
		return array($module->lang($key));
	}
	
	private function onEditUsername(Module_Admin $module, $oldName, $newName)
	{
		$u = $this->user;
		if ($oldName === $newName) {
			return array();
		}
		
		if (false === GWF_Hook::call(GWF_Hook::CHANGE_UNAME, $u, array($newName))) {
			return array(GWF_HTML::err('ERR_HOOK', array( 'Change UNAME')));
		}
		
		if (false === $u->saveVar('user_name', $newName)) {
			GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
			return array();
		}
		
		return array($module->lang('msg_username_changed', array( GWF_HTML::display($oldName)), GWF_HTML::display($newName)));
	}
	
	private function onEditPassword(Module_Admin $module, $newpass)
	{
		$user = $this->user;
		
		if ($newpass === '') {
			return array();
		}
		
		unset($_POST['password']); 
		
		if (false === $user->saveVar('user_password' , GWF_Password::hashPasswordS($newpass))) {
			GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
			return array();
		}
		
		GWF_Hook::call(GWF_Hook::CHANGE_PASSWD, $user, array($newpass, ''));
		
		return array($module->lang('msg_userpass_changed', array( $user->displayUsername(), GWF_HTML::display($newpass))));
	}
	
} 

?>
