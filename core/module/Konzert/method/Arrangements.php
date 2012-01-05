<?php
final class Konzert_Arrangements extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^arrangements.html$ index.php?mo=Konzert&me=Arrangements'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		$module->setNextHREF(GWF_WEB_ROOT.'konzerttermine.html');
		return $this->templateArrangements($module);
	}
	
	private function templateArrangements(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/arrangements'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'title' => $l->lang('title'),
			'h1' => $l->lang('h1'),
			't1' => $l->lang('t1'),
			'h2' => $l->lang('h2'),
			't2' => $l->lang('t2'),
			'h3' => $l->lang('h3'),
			't3' => $l->lang('t3'),
			'title2' => $l->lang('title2'),
			'text2' => $l->lang('text2'),
		);
		return $module->template('arrangements.tpl', $tVars);
	}
}
?>