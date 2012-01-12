<?php

final class PoolTool_About extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^about_pooltool$ index.php?mo=PoolTool&me=About'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::setPageTitle($this->_module->lang('pt_about'));
		GWF_Website::setMetaTags($this->_module->lang('mt_about'));
		GWF_Website::setMetaDescr($this->_module->lang('md_about'));
		
		$tVars = array(
		);
		return $this->_module->templatePHP('about.php', $tVars);
	}
}

?>