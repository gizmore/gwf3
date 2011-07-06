<?php

final class PoolTool_About extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_pooltool$ index.php?mo=PoolTool&me=About'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_about'));
		GWF_Website::setMetaTags($module->lang('mt_about'));
		GWF_Website::setMetaDescr($module->lang('md_about'));
		
		$tVars = array(
		);
		return $module->templatePHP('about.php', $tVars);
	}
}

?>