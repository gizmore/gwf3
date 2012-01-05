<?php
final class Konzert_Ensemble extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^ensemble.html$ index.php?mo=Konzert&me=Ensemble'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter();');

		$module->setNextHREF(GWF_WEB_ROOT.'presseberichte.html');
		
		return $this->templateEnsemble($module);
	}
	
	private function templateEnsemble(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/ensemble'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'title' => $l->lang('title'),
			'text' => $l->lang('text'),
			'text2' => $l->lang('text2'),
			'types' => $l->lang('types'),
			'other' => $l->lang('other'),
			't1' => $l->lang('t1'),
			't2' => $l->lang('t2'),
			'altimg1' => $l->lang('altimg1'),
			'altimg2' => $l->lang('altimg2'),
		);
		return $module->template('ensemble.tpl', $tVars);
	}
}
?>