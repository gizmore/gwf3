<?php
/**
 * @author gizmore
 */
final class Login_Form extends GWF_Method
{
	protected $_tpl = 'login.tpl';
//	public function isCSRFProtected() { return false; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^login/?$ index.php?mo=Login&me=Form'.PHP_EOL;
	}
	
	public function execute()
	{
		$isAjax = isset($_GET['ajax']);
		GWF_Website::setPageTitle($this->module->lang('pt_login'));
		$result = $this->executeMethod();
		return $result;
	}
	
	public function executeMethod()
	{
		if (false !== GWF_Session::getUser())
		{
			return $this->module->error('err_already_logged_in');
		}
		if (false !== Common::getPost('login'))
		{
			return $this->onLogin();
		}
		if (isset($_GET['ajax']))
		{
			return "{error: \"Missing post var: login\"}";
		}
		return $this->form();
	}
	
	public function form()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('title_login')),
			'have_cookies' => GWF_Session::haveCookies(),
// 			'token' => $form->getFormCSRFToken(),
			'tooltip' => $form->getTooltipText('bind_ip'),
			'register' => GWF_Module::loadModuleDB('Register', false, false, true) !== false,
			'recovery' => GWF_Module::loadModuleDB('PasswordForgot', false, false, true) !== false,
		);
		return $this->module->template($this->_tpl, $tVars);
	}

	/**
	 * @return GWF_Form
	 */
	public function getForm()
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $this->module->lang('th_username')),
			'password' => array(GWF_Form::PASSWORD, '', $this->module->lang('th_password')),
			'bind_ip' => array(GWF_Form::CHECKBOX, true, $this->module->lang('th_bind_ip'), $this->module->lang('tt_bind_ip')),
		);
		if ($this->module->cfgCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['login'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_login'));
		return new GWF_Form($this, $data, GWF_Form::METHOD_POST, GWF_Form::CSRF_OFF);
	}
	
	public function onLogin($doValidate=true)
	{
		require_once GWF_CORE_PATH.'module/Login/GWF_LoginFailure.php';
		$isAjax = isset($_GET['ajax']);
		$form = $this->getForm();
		if ($doValidate)
		{
			if (false !== ($errors = $form->validate($this->module, $isAjax))) {
				if ($isAjax) {
					return $errors;
				} else {
					return $errors.$this->form();
				}
			}
		}
		
		$username = Common::getPostString('username');
		$password = Common::getPostString('password');
		$users = GDO::table('GWF_User');
		
		if (false === ($user = $users->selectFirstObject('*', sprintf('user_name=\'%s\' AND user_options&%d=0', $users->escape($username), GWF_User::DELETED))))
		{
			if ($isAjax) {
				return $this->module->error('err_login');
			} else {
				return $this->module->error('err_login').$this->form();
			}
		}
		elseif (true !== ($error = $this->checkBruteforce($user, $isAjax))) {
			if ($isAjax) {
				return $error;
			} else {
				return $error.$this->form();
			}
		}
		elseif (false === GWF_Hook::call(GWF_HOOK::LOGIN_PRE, $user, array($password, ''))) {
			return ''; #GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		elseif (false === (GWF_Password::checkPasswordS($password, $user->getVar('user_password')))) {
			if ($isAjax) {
				return $this->onLoginFailed($user, $isAjax);
			}
			else { 
				return $this->onLoginFailed($user, $isAjax).$this->form();
			}
		}
		
		GWF_Password::clearMemory('password');
		
		return $this->onLoggedIn($user, $isAjax);
	}
	
	private function onLoginFailed(GWF_User $user, $isAjax)
	{
		GWF_LoginFailure::loginFailed($user);
		$time = $this->module->cfgTryExceed();
		$maxtries = $this->module->cfgMaxTries();
		list($tries, $mintime) = GWF_LoginFailure::getFailedData($user, $time);
		
		// Send alert mail?
		if ( ($tries === 1) && ($this->module->cfgAlerts()) )
		{
			$this->onSendAlertMail($user);
		}
		
		return $this->module->error('err_login2', array($maxtries-$tries, GWF_Time::humanDuration($time)));
	}
	
	private function checkBruteforce(GWF_User $user, $isAjax)
	{
		$time = $this->module->cfgTryExceed();
		$maxtries = $this->module->cfgMaxTries();
		$data = GWF_LoginFailure::getFailedData($user, $time);
		
		$tries = $data[0];
		$mintime = $data[1];
		
		if ($tries >= $maxtries) {
			return $this->module->error('err_blocked', array(GWF_Time::humanDuration($mintime - time() + $time)));
		}
		return true;
	}
	
	private function onLoggedIn(GWF_User $user, $isAjax)
	{
		$last_url = GWF_Session::getLastURL();
		
		if (false === GWF_Session::onLogin($user, isset($_POST['bind_ip']))) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		require_once GWF_CORE_PATH.'module/Login/GWF_LoginHistory.php';
		GWF_LoginHistory::insertEvent($user->getID());
		
		# save last login time
		$user->saveVar('user_lastlogin', time());
		
		if ($this->module->cfgCleanupAlways()) {
			GWF_LoginFailure::cleanupUser($user->getID());
		}
		
		if ($isAjax)
		{
			return sprintf('1:%s', GWF_Session::getSessID());
		}
		else
		{
			GWF_Session::set('GWF_LOGIN_BACK', $last_url);
			
			if (false !== ($lang = $user->getLanguage())) {
				GWF_Language::setCurrentLanguage($lang);
			}
			
			if (0 < ($fails = GWF_LoginFailure::getFailCount($user, $this->module->cfgTryExceed()))) {
				GWF_Session::set('GWF_LOGIN_FAILS', $fails);
			}
			
			GWF_Website::redirect(GWF_WEB_ROOT.'welcome');
		}
	}
	
	private function onSendAlertMail(GWF_User $user)
	{
		if ('' === ($to = $user->getValidMail()))
		{
			return;
		}
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($to);
		$mail->setSubject($this->module->langUser($user, 'alert_subj'));
		$mail->setBody($this->module->langUser($user, 'alert_body', array($user->displayUsername(), $_SERVER['REMOTE_ADDR'])));
		
		return $mail->sendToUser($user);
	}
	
	#################
	### Validator ###
	#################
	public function validate_username(Module_Login $module, $arg) { return false; }
	public function validate_password(Module_Login $module, $arg) { return false; } 
}

?>
