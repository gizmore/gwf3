<?php
final class Konzert_Exklusiv extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^exklusiv.html$ index.php?mo=Konzert&me=Exklusiv'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter();');
		$this->module->setNextHREF(GWF_WEB_ROOT.'kontakt.html');
		return $this->templateExklusiv();
	}
	
	private function templateExklusiv()
	{
		$l = new GWF_LangTrans($this->module->getModuleFilePath('lang/exklusiv'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'l' => $l,
		);
		return $this->module->template('exklusiv.tpl', $tVars);
	}
}
?>