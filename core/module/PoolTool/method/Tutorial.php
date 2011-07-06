<?php
final class PoolTool_Tutorial extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^pooltool_tutorial$ index.php?mo=PoolTool&me=Tutorial'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_tut'));
		GWF_Website::setMetaTags($module->lang('mt_tut'));
		GWF_Website::setMetaDescr($module->lang('md_tut'));
		
		$tVars = array(
		);
		return $module->templatePHP('tutorial.php', $tVars);
	}
}
?>