<?php
final class Konzert_Exklusiv extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^exklusiv.html$ index.php?mo=Konzert&me=Exklusiv'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter();');
		$module->setNextHREF(GWF_WEB_ROOT.'kontakt.html');
		return $this->templateExklusiv($module);
	}
	
	private function templateExklusiv(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/exklusiv'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'l' => $l,
		);
		return $module->template('exklusiv.tpl', $tVars);
	}
}
?>