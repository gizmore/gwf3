<?php
final class Konzert_Impressum extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^impressum.html$ index.php?mo=Konzert&me=Impressum'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$module->setNextHREF(GWF_WEB_ROOT.'sponsoren.html');
		return $this->templateImpressum($module);
	}
	
	private function templateImpressum(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/impressum'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'l' => $l,
		);
		return $module->template('impressum.tpl', $tVars);
	}
}
?>