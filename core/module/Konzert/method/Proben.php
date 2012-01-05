<?php
final class Konzert_Proben extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^hoehrproben.html$ index.php?mo=Konzert&me=Proben'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$module->setNextHREF(GWF_WEB_ROOT.'exklusiv.html');
		return $this->templateProben($module);
	}
	
	private function templateProben(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($module->getModuleFilePath('lang/hoehrproben'));
		GWF_Website::setPageTitle($l->lang('page_title'));
		$tVars = array(
			'l' => $l,
		);
		return $module->template('proben.tpl', $tVars);
	}
	
}
?>