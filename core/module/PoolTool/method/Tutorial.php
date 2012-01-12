<?php
final class PoolTool_Tutorial extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^pooltool_tutorial$ index.php?mo=PoolTool&me=Tutorial'.PHP_EOL;
	}

	public function execute()
	{
		GWF_Website::setPageTitle($this->_module->lang('pt_tut'));
		GWF_Website::setMetaTags($this->_module->lang('mt_tut'));
		GWF_Website::setMetaDescr($this->_module->lang('md_tut'));
		
		$tVars = array(
		);
		return $this->_module->templatePHP('tutorial.php', $tVars);
	}
}
?>