<?php
final class Konzert_Repertoire extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^repertoire.html$ index.php?mo=Konzert&me=Repertoire'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initRepertoireSlideshow(); initGhostwriter();');
		
		$module->setNextHREF(GWF_WEB_ROOT.'arrangements.html');
		
		return $this->templateRepertoire($module);
	}
	
	private function templateRepertoire(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/repertoire'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'text' => $l->lang('text'),
			'rep' => $l->lang('repertoire'),
			't1' => $l->lang('t1'),
			'altimg' => $l->lang('altimg'),
		);
		return $module->template('repertoire.tpl', $tVars);
	}
}
?>