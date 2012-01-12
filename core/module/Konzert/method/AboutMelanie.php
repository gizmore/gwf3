<?php
final class Konzert_AboutMelanie extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^melanie_gobbo.html$ index.php?mo=Konzert&me=AboutMelanie'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter(); initAboutSlideshow();');
		
		$this->_module->setNextHREF(GWF_WEB_ROOT.'biography.html');
		
		return $this->templateAbout($this->_module);
	}
	
	private function templateAbout()
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/about_meli'));
		GWF_Website::setPageTitle($l->lang('page_title'));
		$tVars = array(
			'l' => $l,
		);
		return $this->_module->template('about_melanie.tpl', $tVars);
	}
}
?>