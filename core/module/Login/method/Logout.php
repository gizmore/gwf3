<?php
/**
 * @author gizmore
 */
final class Login_Logout extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^logout$ index.php?mo=Login&me=Logout'.PHP_EOL;
//			'RewriteRule ^ausloggen$ index.php?mo=Login&me=Logout'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === GWF_Session::getUser())
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}

		if (false === GWF_Session::onLogout())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		$tVars = array(
			'title' => $this->module->lang('Logout'),
			'info' => $this->module->lang('logout_info'),
		);
		return $this->module->template('logout.tpl', $tVars);
	}
}

?>
