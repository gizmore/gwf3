<?php
final class Konzert_Proben extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^hoehrproben.html$ index.php?mo=Konzert&me=Proben'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$this->_module->setNextHREF(GWF_WEB_ROOT.'exklusiv.html');
		return $this->templateProben($this->_module);
	}
	
	private function templateProben(Module_Konzert $module)
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/hoehrproben'));
		GWF_Website::setPageTitle($l->lang('page_title'));
		$tVars = array(
			'l' => $l,
		);
		return $this->_module->template('proben.tpl', $tVars);
	}
	
}
?>