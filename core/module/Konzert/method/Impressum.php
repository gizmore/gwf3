<?php
final class Konzert_Impressum extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^impressum.html$ index.php?mo=Konzert&me=Impressum'.PHP_EOL;
	}

	public function execute()
	{
		$this->_module->setNextHREF(GWF_WEB_ROOT.'sponsoren.html');
		return $this->templateImpressum();
	}
	
	private function templateImpressum()
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/impressum'));
		
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$tVars = array(
			'l' => $l,
		);
		return $this->_module->template('impressum.tpl', $tVars);
	}
}
?>