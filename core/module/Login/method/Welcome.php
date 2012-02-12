<?php
/**
 * @author gizmore
 */
final class Login_Welcome extends GWF_Method
{
	public function getHTAccess()
	{
		return
//			'RewriteRule ^welcome_back$ index.php?mo=Login&me=Welcome'.PHP_EOL.
			'RewriteRule ^welcome$ index.php?mo=Login&me=Welcome&activated=true'.PHP_EOL;
//			'RewriteRule ^willkommen$ index.php?mo=Login&me=Welcome'.PHP_EOL.
//			'RewriteRule ^willkommen_zurück$ index.php?mo=Login&me=Welcome&activated=true'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->welcome(Common::getGet('activated') !== false);
	}
	
	private function welcome($first_time)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		require_once GWF_CORE_PATH.'module/Login/GWF_LoginHistory.php';
		
		GWF_Hook::call(GWF_Hook::LOGIN_AFTER, $user, array(GWF_Session::getOrDefault('GWF_LOGIN_BACK', GWF_WEB_ROOT)));
		
		$fails = GWF_Session::getOrDefault('GWF_LOGIN_FAILS', 0);
		GWF_Session::remove('GWF_LOGIN_FAILS');

		if ($fails > 0)
		{
			$fails = $this->module->lang('err_failures', array( $fails));
		}
		else 
		{
			$fails = '';
		}
		
		$href_hist = $this->module->getMethodURL('History');
		$username = $user->display('user_name');
		
		if (false !== ($ll = GWF_LoginHistory::getLastLogin($user->getID()))) {
			$last_login = $this->module->lang('msg_last_login', array($ll->displayDate(), $ll->displayIP(), $ll->displayHostname(), $href_hist));
			$welcome = $this->module->lang('welcome_back', array($username, $ll->displayDate(), $ll->displayIP()));
		} else {
			$last_login = '';
			$welcome = $this->module->lang('welcome', array($username));
		}
		
		$tVars = array(
//			'first_time' => $first_time,
			'welcome' => $welcome,
//			'username' => $user->display('user_name'),
			'fails' => $fails,
			'last_login' => $last_login,
			'href_history' => $href_hist,
		);
		return $this->module->template('welcome.tpl', $tVars);
	}
}
?>
