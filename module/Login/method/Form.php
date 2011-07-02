<?php
/**
 * @author gizmore
 */
final class Login_Form extends GWF_Method
{
//	public function isCSRFProtected() { return false; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^login/?$ index.php?mo=Login&me=Form'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_login'));
		
		if (false !== Common::getPost('login')) {
			return $this->onLogin($module);
		}
		return $this->form($module);
	}
	
	public function form(Module_Login $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('title_login')),
			'have_cookies' => GWF_Session::haveCookies(),
			'token' => $form->getFormCSRFToken(),
			'tooltip' => $form->getTooltipText('bind_ip'),
		);
		return $module->template('login.tpl', $tVars);
	}
	
	/**
	 * @param Module_Login $module
	 * @return GWF_Form
	 */
	public function getForm(Module_Login $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $module->lang('th_username')),
			'password' => array(GWF_Form::PASSWORD, '', $module->lang('th_password')),
			'bind_ip' => array(GWF_Form::CHECKBOX, true, $module->lang('th_bind_ip'), $module->lang('tt_bind_ip')),
		);
		if ($module->cfgCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['login'] = array(GWF_Form::SUBMIT, $module->lang('btn_login'));
		return new GWF_Form($this, $data);
	}
	
	public function onLogin(Module_Login $module)
	{
		require_once 'module/Login/GWF_LoginFailure.php';
		$isAjax = isset($_GET['ajax']);
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module, $isAjax))) {
			if ($isAjax) {
				return $errors;
			} else {
				return $errors.$this->form($module);
			}
		}
		
		$username = Common::getPost('username');
		$password = Common::getPost('password');
		$users = GDO::table('GWF_User');
		
		if (false === ($user = $users->selectFirstObject('*', sprintf('user_name=\'%s\' AND user_options&%d=0', $users->escape($username), GWF_User::DELETED))))
		{
			if ($isAjax) {
				return $module->error('err_login');
			} else {
				return $module->error('err_login').$this->form($module);
			}
		}
		elseif (true !== ($error = $this->checkBruteforce($module, $user, $isAjax))) {
			if ($isAjax) {
				return $error;
			} else {
				return $error.$this->form($module);
			}
		}
		elseif (false === GWF_Hook::call(GWF_HOOK::LOGIN_PRE, $user, array($password, ''))) {
			return ''; #GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		elseif (false === (GWF_Password::checkPasswordS($password, $user->getVar('user_password')))) {
			if ($isAjax) {
				return $this->onLoginFailed($module, $user, $isAjax);
			}
			else { 
				return $this->onLoginFailed($module, $user, $isAjax).$this->form($module);
			}
		}
		
		GWF_Password::clearMemory('password');
		
		return $this->onLoggedIn($module, $user, $isAjax);
	}
	
	private function onLoginFailed(Module_Login $module, GWF_User $user, $isAjax)
	{
		GWF_LoginFailure::loginFailed($user);
		$time = $module->cfgTryExceed();
		$maxtries = $module->cfgMaxTries();
		list($tries, $mintime) = GWF_LoginFailure::getFailedData($user, $time);
		return $module->error('err_login2', array($maxtries-$tries, GWF_Time::humanDuration($time)));
	}
	
	private function checkBruteforce(Module_Login $module, GWF_User $user, $isAjax)
	{
		$time = $module->cfgTryExceed();
		$maxtries = $module->cfgMaxTries();
		$data = GWF_LoginFailure::getFailedData($user, $time);
		
		$tries = $data[0];
		$mintime = $data[1];
		
		if ($tries >= $maxtries) {
			return $module->error('err_blocked', array(GWF_Time::humanDuration($mintime - time() + $time)));
		}
		return true;
	}
	
	private function onLoggedIn(Module_Login $module, GWF_User $user, $isAjax)
	{
		$last_url = GWF_Session::getLastURL();
		
		if (false === GWF_Session::onLogin($user, isset($_POST['bind_ip']))) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		require_once 'module/Login/GWF_LoginHistory.php';
		GWF_LoginHistory::insertEvent($user->getID());
		
		# save last login time
		$user->saveVar('user_lastlogin', time());
		
		if ($module->cfgCleanupAlways()) {
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
			
			if (0 < ($fails = GWF_LoginFailure::getFailCount($user, $module->cfgTryExceed()))) {
				GWF_Session::set('GWF_LOGIN_FAILS', $fails);
			}
			
			GWF_Website::redirect(GWF_WEB_ROOT.'welcome');
		}
	}
	
	#################
	### Validator ###
	#################
	public function validate_username(Module_Login $module, $arg) { return false; }
	public function validate_password(Module_Login $module, $arg) { return false; } 
}

?>