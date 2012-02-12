<?php
final class Lamb_Shadowlamb extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^shadowlamb/?$ index.php?mo=Lamb&me=Shadowlamb'.PHP_EOL;
	}
	
	public function execute()
	{
		require_once 'core/module/Lamb/Lamb_User.php';
		require_once 'core/module/Lamb/lamb_module/Shadowlamb/core/SR_Player.php';
		
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Lamb/shadowlamb.js?v=2');
		
		return $this->templateShadowlamb();
	}
	
	private function templateShadowlamb()
	{
		$tVars = array(
			'account_select' => $this->module->getMethod('Client')->selectAccounts(),
		);
		return $this->module->templatePHP('shadowlamb.php', $tVars);
	}
}
