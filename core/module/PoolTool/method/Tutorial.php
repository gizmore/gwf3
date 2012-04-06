<?php
final class PoolTool_Tutorial extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^pooltool_tutorial$ index.php?mo=PoolTool&me=Tutorial'.PHP_EOL;
	}

	public function execute()
	{
		GWF_Website::setPageTitle($this->module->lang('pt_tut'));
		GWF_Website::setMetaTags($this->module->lang('mt_tut'));
		GWF_Website::setMetaDescr($this->module->lang('md_tut'));
		
		$tVars = array(
		);
		return $this->module->templatePHP('tutorial.php', $tVars);
	}
}
?>