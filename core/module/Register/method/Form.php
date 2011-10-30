<?php
final class Register_Form extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^register/?$ index.php?mo=Register&me=Form&se=1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_register'));
		if (false !== (Common::getPost('register'))) {
			return $this->onRegister($module);
		}
		return $this->templateForm($module);
	}
	
	private function getForm(Module_Register $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $module->lang('th_username'), $module->lang('tt_username', array(GWF_User::USERNAME_LENGTH))),
			'password' => array(GWF_Form::PASSWORD, '', $module->lang('th_password'), $module->lang('tt_password')),
		);
		
		if ($module->wantEmailActivation()) { 
			$data['email'] = array(GWF_Form::STRING, '', $module->lang('th_email'), $module->lang('tt_email'));
		}
		
		if ($module->hasMinAge()) {
			$data['birthdate'] = array(GWF_Form::DATE, 0, $module->lang('th_birthdate'), '', GWF_Date::LEN_DAY);
		}
		
		if ($module->wantCountrySelect()) {
			$cid = isset($_POST['countryid']) ? $_POST['countryid'] : GWF_IP2Country::detectCountryID();
			$data['countryid'] = array(GWF_Form::SELECT, GWF_CountrySelect::single('countryid', $cid), $module->lang('th_countryid'));
		}
		
		if ($module->isTOSForced()) {
			if ('' !== ($href_tos = $module->cfgHrefTos())) {
				$data['tos'] = array(GWF_Form::CHECKBOX, false, $module->lang('th_tos2', array(htmlspecialchars($href_tos))));
			} else {
				$data['tos'] = array(GWF_Form::CHECKBOX, false, $module->lang('th_tos'));
			}
			$data['eula'] = array(GWF_Form::VALIDATOR);
		}

		if ($module->wantCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		
		$data['register'] = array(GWF_Form::SUBMIT, $module->lang('btn_register'));
		
		return new GWF_Form($this, $data);
	}
	
	private function templateForm(Module_Register $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('title_register'), GWF_WEB_ROOT.'register'),
			'cookie_info' => GWF_Session::haveCookies() ? '' : GWF_HTML::err('ERR_COOKIES_REQUIRED', NULL, false),
		);
		return $module->template('register.tpl', $tVars);
	}
	
	private function onRegister(Module_Register $module)
	{
		$form = $this->getForm($module);
		
		$errorsA = $errorsB = '';
		if ( (false !== ($errorsA = $form->validate($module))) || (false !== ($errorsB = $this->onRegisterB($module))) ) {
			return $errorsA.$errorsB.$this->templateForm($module);
		}
		
		$username = Common::getPost('username');
		$password = Common::getPost('password');
		$email = Common::getPost('email');
		$birthdate = sprintf('%04d%02d%02d', Common::getPost('birthdatey'), Common::getPost('birthdatem'), Common::getPost('birthdated'));
		$default_country = $module->cfgDetectCountry() ? GWF_IP2Country::detectCountryID() : 0;
		$countryid = $form->getVar('countryid', $default_country);
		require_once GWF_CORE_PATH.'module/Register/GWF_UserActivation.php';
		$token = GWF_UserActivation::generateToken();
		$ua = new GWF_UserActivation(array(
			'username' => $username,
			'email' => $email,
			'token' => $token,
			'birthdate' => $birthdate,
			'countryid' => $countryid,
			'password' => GWF_Password::hashPasswordS($password),
			'timestamp' => time(),
			'ip' => GWF_IP6::getIP(GWF_IP_EXACT),
		));
		
		if (false === ($ua->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateForm($module);
		}

		if ($module->wantEmailActivation()) {
			return $this->sendEmail($module, $username, $email, $token, $password);
		}
		else {
			GWF_Website::redirect(GWF_WEB_ROOT.'quick_activate/'.$token);
		}
		return $module->message('msg_registered');
	}

	/**
	 * Do additional checks and validation.
	 * returns error or false.
	 * @param Module_Register $module
	 * @return mixed
	 */
	private function onRegisterB(Module_Register $module)
	{
		$errors = array();
		
		if ($module->hasIPActivatedRecently()) {
			$errors[] = $module->lang('err_ip_timeout');
		}
		
		if ($module->isTOSForced()) {
			if (!isset($_POST['tos'])) {
				$errors[] = $module->lang('err_tos');
			}
		}
		
		return count($errors) === 0 ? false : GWF_HTML::errorA($module->getName(), $errors);
	}
	
	private function sendEmail(Module_Register $module, $username, $email, $token, $password)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject($module->lang('regmail_subject'));
		$href = Common::getAbsoluteURL('activate/'.$token);
		$a = GWF_HTML::anchor($href, $href);
		if ($module->isPlaintextInEmail()) {
			$pt = $module->lang('regmail_ptbody', array(htmlspecialchars($username), htmlspecialchars($password)));
		} else {
			$pt = '';
		}
		$mail->setBody($module->lang('regmail_body', array($username, $a, $pt)));
		
		return $mail->sendAsHTML() ? $module->message('msg_mail_sent') : GWF_HTML::err('ERR_MAIL_SENT');
	}
	
	##################
	### Validators ###
	##################
	public function validate_username(Module_Register $module, $arg)
	{
		if (false !== (GWF_User::getByName($arg))) {
			return $module->lang('err_name_taken');
		}
		if (!GWF_Validator::isValidUsername($arg)) {
			return $module->lang('err_name_invalid');
		}
		return false;
	}
	
	public function validate_password(Module_Register $module, $arg)
	{
		return GWF_Validator::isValidPassword($arg) ? false : $module->lang('err_pass_weak');
	}
	
	public function validate_email(Module_Register $module, $arg)
	{
		if (!$module->isEMailAllowedTwice()) {
			if (false !== (GWF_User::getByEmail($arg))) {
				return $module->lang('err_email_taken');
			}
		}
		if (!GWF_Validator::isValidEmail($arg)) {
			return $module->lang('err_email_invalid');
		}
		if (GWF_BlackMail::isBlacklisted($arg))
		{
			return $module->lang('err_domain_banned');
		}
		return false;
	}
	 
	public function validate_birthdate(Module_Register $module, $arg)
	{
		if (!GWF_Time::isValidDate($arg, true, 8))
		{
			return $module->lang('err_birthdate');
		}
		
		if (0 < ($minage = $module->getMinAge())) {
			if ($minage > ($age = GWF_Time::getAge($arg))) {
				return $module->lang('err_minage', array($minage));
			}
		}
		return false;
	}
	 
	public function validate_countryid(Module_Register $module, $arg)
	{
		$countryid = (int) $arg;
		if ($countryid !== 0)
		{
			if (GWF_Country::getByID($countryid) === false)
			{
				return $module->lang('err_country');
			}
		}
		return false;
	}
	
	public function validate_eula(Module_Register $module, $arg)
	{
		if (!isset($_POST['tos'])) {
			return $module->lang('err_tos');
		}
		return false;
	}
	
}