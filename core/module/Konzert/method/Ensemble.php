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

		$this->_module->setNextHREF(GWF_WEB_ROOT.'presseberichte.html');
		
		return $this->templateEnsemble($this->_module);
	}
	
	private function templateEnsemble()
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/ensemble'));
		
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
		return $this->_module->template('ensemble.tpl', $tVars);
	}
}
?>