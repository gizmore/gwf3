<?php

final class Profile_Form extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^profile_settings$ index.php?mo=Profile&me=Form'.PHP_EOL;
	}

	public function execute()
	{
		if (false !== Common::getPost('edit')) {
			return $this->onEditSettings($this->_module).$this->templateSettings($this->_module);
		}

		GWF_Website::setPageTitle($this->_module->lang('pt_settings'));
		GWF_Website::setMetaTags($this->_module->lang('mt_settings'));
		GWF_Website::setMetaTags($this->_module->lang('md_settings'));
		
		return $this->templateSettings($this->_module);
	}
	
	private function getProfile()
	{
		return GWF_Profile::getProfile(GWF_Session::getUserID());
	}
	
	private function getForm(Module_Profile $module, GWF_Profile $profile)
	{
		$data = array(
			'firstname' => array(GWF_Form::STRING, $profile->getVar('prof_firstname'), $this->_module->lang('th_firstname'), '', 32, false),
			'lastname' => array(GWF_Form::STRING, $profile->getVar('prof_lastname'), $this->_module->lang('th_lastname'), '', 32, false),
			'street' => array(GWF_Form::STRING, $profile->getVar('prof_street'), $this->_module->lang('th_street'), '', 32, false),
			'zip' => array(GWF_Form::STRING, $profile->getVar('prof_zip'), $this->_module->lang('th_zip'), '', 6, false),
			'city' => array(GWF_Form::STRING, $profile->getVar('prof_city'), $this->_module->lang('th_city'), '', 32, false),
			'div1' => array(GWF_Form::DIVIDER),
			'tel' => array(GWF_Form::STRING, $profile->getVar('prof_tel'), $this->_module->lang('th_tel'), '', 16, false),
			'mobile' => array(GWF_Form::STRING, $profile->getVar('prof_mobile'), $this->_module->lang('th_mobile'), '', 16, false),
			'div2' => array(GWF_Form::DIVIDER),
			'website' => array(GWF_Form::STRING, $profile->getVar('prof_website'), $this->_module->lang('th_website'), '', 32, false),
			'icq' => array(GWF_Form::STRING, $profile->getVar('prof_icq'), $this->_module->lang('th_icq'), '', 16, false),
			'msn' => array(GWF_Form::STRING, $profile->getVar('prof_msn'), $this->_module->lang('th_msn'), '', 32, false),
			'jabber' => array(GWF_Form::STRING, $profile->getVar('prof_jabber'), $this->_module->lang('th_jabber'), '', 32, false),
			'skype' => array(GWF_Form::STRING, $profile->getVar('prof_skype'), $this->_module->lang('th_skype'), '', 32, false),
			'yahoo' => array(GWF_Form::STRING, $profile->getVar('prof_yahoo'), $this->_module->lang('th_yahoo'), '', 32, false),
			'aim' => array(GWF_Form::STRING, $profile->getVar('prof_aim'), $this->_module->lang('th_aim'), '', 32, false),
			'irc' => array(GWF_Form::STRING, $profile->getVar('prof_irc'), $this->_module->lang('th_irc'), '', 32, false),
			'div3' => array(GWF_Form::DIVIDER),
			'about_me' => array(GWF_Form::MESSAGE, $profile->getVar('prof_about_me'), $this->_module->lang('th_about_me'), '', 0, false),
//			'showbday' => array(GWF_Form::CHECKBOX, !$profile->isBirthdayHidden(), $this->_module->lang('th_showbday')),
			'hidecountry' => array(GWF_Form::CHECKBOX, $profile->isCountryHidden(), $this->_module->lang('th_hidecountry')),
			'hidemail' => array(GWF_Form::CHECKBOX, $profile->isEmailHidden(), $this->_module->lang('th_hidemail')),
			'hideguests' => array(GWF_Form::CHECKBOX, $profile->isGuestHidden(), $this->_module->lang('th_hideguest')),
			'hiderobots' => array(GWF_Form::CHECKBOX, $profile->isRobotHidden(), $this->_module->lang('th_hiderobot'), $this->_module->lang('tt_hiderobot')),
//			'hidden' => array(GWF_Form::CHECKBOX, $profile->isHidden(), $this->_module->lang('th_hidden')),
			'level_all' => array(GWF_Form::INT, $profile->getVar('prof_level_all'), $this->_module->lang('th_level_all'), $this->_module->lang('tt_level_all'), 5, true),
			'level_contact' => array(GWF_Form::INT, $profile->getVar('prof_level_contact'), $this->_module->lang('th_level_contact'), $this->_module->lang('tt_level_contact'), 5, true),
			'edit' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}

	private function templateSettings()
	{
		$profile = $this->getProfile();
		$form = $this->getForm($this->_module, $profile);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_settings')),
		);
		return $this->_module->templatePHP('settings.php', $tVars);
	}

	private function onEditSettings()
	{
		$profile = $this->getProfile();
		$form = $this->getForm($this->_module, $profile);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}
		
//		$profile->saveOption(GWF_Profile::SHOW_BIRTHDAY, isset($_POST['showbday']));
//		$profile->saveOption(GWF_Profile::HIDDEN, isset($_POST['hidden']));
		$profile->saveOption(GWF_Profile::HIDE_COUNTRY, isset($_POST['hidecountry']));
		$profile->saveOption(GWF_Profile::HIDE_EMAIL, isset($_POST['hidemail']));
		$profile->saveOption(GWF_Profile::HIDE_GUESTS, isset($_POST['hideguests']));
		$profile->saveOption(GWF_Profile::HIDE_ROBOTS, isset($_POST['hiderobots']));
		
		if (false === $profile->saveVars(array(
			'prof_website' => $_POST['website'],
			'prof_about_me' => $_POST['about_me'],
			'prof_firstname' => $_POST['firstname'],
			'prof_lastname' => $_POST['lastname'],
			'prof_street' => $_POST['street'],
			'prof_zip' => $_POST['zip'],
			'prof_city' => $_POST['city'],
			'prof_tel' => $_POST['tel'],
			'prof_mobile' => $_POST['mobile'],
			'prof_icq' => $_POST['icq'],
			'prof_msn' => $_POST['msn'],
			'prof_jabber' => $_POST['jabber'],
			'prof_skype' => $_POST['skype'],
			'prof_yahoo' => $_POST['yahoo'],
			'prof_aim' => $_POST['aim'],
			'prof_irc' => $_POST['irc'],
			'prof_level_all' => $_POST['level_all'],
			'prof_level_contact' => $_POST['level_contact'],
		
		))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
				
		return $this->_module->message('msg_edited');
	}
	
	##################
	### Validators ###
	##################
	public function validate_website(Module_Profile $m, $arg) { return GWF_Validator::validateURL($m, 'website', $arg, true, false); }
	public function validate_firstname(Module_Profile $m, $arg) { return $this->validateString($m, 'firstname', $arg, 63); }
	public function validate_lastname(Module_Profile $m, $arg) { return $this->validateString($m, 'lastname', $arg, 63); }
	public function validate_street(Module_Profile $m, $arg) { return $this->validateString($m, 'street', $arg, 63); }
	public function validate_zip(Module_Profile $m, $arg) { return $this->validateString($m, 'zip', $arg, 16); }
	public function validate_city(Module_Profile $m, $arg) { return $this->validateString($m, 'city', $arg, 63); }
	public function validate_tel(Module_Profile $m, $arg) { return $this->validateNumber($m, 'tel', $arg, 24); }
	public function validate_mobile(Module_Profile $m, $arg) { return $this->validateNumber($m, 'mobile', $arg, 16); }
	public function validate_icq(Module_Profile $m, $arg) { return $this->validateNumber($m, 'icq', $arg, 16); }
	public function validate_msn(Module_Profile $m, $arg) { return $this->validateEMail($m, 'msn', $arg); }
	public function validate_jabber(Module_Profile $m, $arg) { return $this->validateEMail($m, 'jabber', $arg); }
	public function validate_skype(Module_Profile $m, $arg) { return $this->validateString($m, 'skype', $arg, 63); }
	public function validate_yahoo(Module_Profile $m, $arg) { return $this->validateString($m, 'yahoo', $arg, 63); }
	public function validate_aim(Module_Profile $m, $arg) { return $this->validateString($m, 'aim', $arg, 63); }
	public function validate_irc(Module_Profile $m, $arg) { return $this->validateString($m, 'irc', $arg, 255); }
	public function validate_about_me(Module_Profile $m, $arg) { return $this->validateString($m, 'about_me', $arg, $m->cfgMaxAboutLen()); }
	public function validate_level_all(Module_Profile $m, $arg) { return $this->validateNumber($m, 'level_all', $arg, 63); }
	public function validate_level_contact(Module_Profile $m, $arg) { return $this->validateNumber($m, 'level_contact', $arg, 63); }
	
	private function validateString(Module_Profile $m, $key, $arg, $max)
	{
		return GWF_Validator::validateString($m, $key, $arg, 0, $max, true);
	}
	
	private function validateNumber(Module_Profile $m, $key, $arg, $max)
	{
		$arg = str_replace(' ', '', $arg);
		return GWF_Validator::validateInt($m, $key, $arg, '0', bcpow('10', "$max"), true);
	}
	
	private function validateEMail(Module_Profile $m, $key, $arg)
	{
		return GWF_Validator::validateEMail($m, $key, $arg, true, true);
	}
}

?>