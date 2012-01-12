<?php
final class Konzert_Repertoire extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^repertoire.html$ index.php?mo=Konzert&me=Repertoire'.PHP_EOL;
	}

	public function execute()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initRepertoireSlideshow(); initGhostwriter();');
		
		$this->_module->setNextHREF(GWF_WEB_ROOT.'arrangements.html');
		
		return $this->templateRepertoire($this->_module);
	}
	
	private function templateRepertoire()
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/repertoire'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'text' => $l->lang('text'),
			'rep' => $l->lang('repertoire'),
			't1' => $l->lang('t1'),
			'altimg' => $l->lang('altimg'),
		);
		return $this->_module->template('repertoire.tpl', $tVars);
	}
}
?>