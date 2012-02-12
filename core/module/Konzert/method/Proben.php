<?php
final class Konzert_Proben extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^hoehrproben.html$ index.php?mo=Konzert&me=Proben'.PHP_EOL;
	}

	public function execute()
	{
		$this->module->setNextHREF(GWF_WEB_ROOT.'exklusiv.html');
		return $this->templateProben();
	}
	
	private function templateProben()
	{
		$l = new GWF_LangTrans($this->module->getModuleFilePath('lang/hoehrproben'));
		GWF_Website::setPageTitle($l->lang('page_title'));
		$tVars = array(
			'l' => $l,
		);
		return $this->module->template('proben.tpl', $tVars);
	}
	
}
?>