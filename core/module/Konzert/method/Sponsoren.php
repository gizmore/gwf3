<?php
final class Konzert_Sponsoren extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^sponsoren.html$ index.php?mo=Konzert&me=Sponsoren'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateSponsoren($module);
	}
	
	private function templateSponsoren(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/sponsoren'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'title' => $l->lang('title'),
			'subtitle' => $l->lang('subtitle'),
		);
		return $module->template('sponsoren.tpl', $tVars);
	}
}
?>