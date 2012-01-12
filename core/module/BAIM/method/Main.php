<?php
final class BAIM_Main extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_baim$ index.php?mo=BAIM&me=Main'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($this->_module->lang('pt_main'));
//		GWF_Website::setMetaTags($this->_module->lang('mt_main'));
//		GWF_Website::setMetaDescr($this->_module->lang('md_main'));
		
		$tVars = array(
//			'news' => $this->getNews(),
		);
		return $this->_module->templatePHP('main.php', $tVars);
	}
	
	private function getNews()
	{
		if (false === ($newsmodule = Module::getModule('News'))) {
			return '';
		}
		return $newsmodule->getNewsBox(1);
	}
}

?>
