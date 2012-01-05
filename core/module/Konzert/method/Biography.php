<?php
final class Konzert_Biography extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^biography.html$ index.php?mo=Konzert&me=Biography'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter(); initBiographySlideshow();');
		
		$module->setNextHREF(GWF_WEB_ROOT.'repertoire.html');
		
		return $this->templateBiography($module);
	}
	
	private function templateBiography(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/biography'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'title' => $l->lang('title'),
			'name' => $l->lang('name'),
			'sopran' => $l->lang('sopran'),
			'text' => $l->lang('text'),
			't1' => $l->lang('t1'),
			'altimg' => $l->lang('t1'),
		);
		return $module->template('biography.tpl', $tVars);
	}
}
?>