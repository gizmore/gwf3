<?php
final class Lamb_Shadowlamb extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^shadowlamb$ index.php?mo=Lamb&me=Shadowlamb'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		$tVars = array(
			'account_select' => '',
		);
		return $module->template('shadowlamb.php', NULL, $tVars);
	}
}