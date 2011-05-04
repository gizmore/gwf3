<?php
final class BAIM_Main extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_baim$ index.php?mo=BAIM&me=Main'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_main'));
//		GWF_Website::setMetaTags($module->lang('mt_main'));
//		GWF_Website::setMetaDescr($module->lang('md_main'));
		
		$tVars = array(
//			'news' => $this->getNews(),
		);
		return $module->templatePHP('main.php', $tVars);
	}
	
	private function getNews()
	{
		if (false === ($module = Module::getModule('News'))) {
			return '';
		}
		return $module->getNewsBox(1);
	}
}

?>