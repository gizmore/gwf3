<?php
/**
 * @author gizmore
 */
final class Login_Logout extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^logout$ index.php?mo=Login&me=Logout'.PHP_EOL;
//			'RewriteRule ^ausloggen$ index.php?mo=Login&me=Logout'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false === GWF_Session::onLogout()) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		$tVars = array(
			'title' => $module->lang('Logout'),
			'info' => $module->lang('logout_info'),
		);
		return $module->template('logout.tpl', $tVars);
	}
}

?>