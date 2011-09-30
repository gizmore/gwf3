<?php
final class Lamb_Shadowlamb extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^shadowlamb/?$ index.php?mo=Lamb&me=Shadowlamb'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		require_once 'core/module/Lamb/Lamb_User.php';
		require_once 'core/module/Lamb/lamb_module/Shadowlamb/core/SR_Player.php';
		
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Lamb/shadowlamb.js?v=2');
		
		return $this->templateShadowlamb($module);
	}
	
	private function templateShadowlamb(Module_Lamb $module)
	{
		$tVars = array(
			'account_select' => $module->getMethod('Client')->selectAccounts($module),
		);
		return $module->templatePHP('shadowlamb.php', $tVars);
	}
}