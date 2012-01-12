<?php
final class Konzert_Termine extends GWF_Method
{
	const DEFAULT_BY = 'kt_date';
	const DEFAULT_DIR = 'ASC';
	const IPP = 5;
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^konzerttermine.html$ index.php?mo=Konzert&me=Termine'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_Website::addJavascriptOnload('konzertInitTermine();');
		
		$this->_module->setNextHREF(GWF_WEB_ROOT.'ensemble.html');
		
		return $this->templateTermine($this->_module);
	}
	
	private function templateTermine()
	{
		$l = new GWF_LangTrans($this->_module->getModuleFilePath('lang/termine'));
		GWF_Website::setPageTitle($l->lang('page_title'));
		
		$termine = GDO::table('Konzert_Termin');
		
		$where = 'kt_options&1';
		
		$by = Common::getGetString('by', self::DEFAULT_BY);
		$dir = Common::getGetString('dir', self::DEFAULT_DIR);
		$orderby = $termine->getMultiOrderby($by, $dir);
		
		$nItems = $termine->countRows($where);
		$nPages = GWF_PageMenu::getPagecount(self::IPP, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, self::IPP);
		
		$tVars = array(
			'l' => $l,
			'href_admin' => $this->_module->getMethodURL('AdminTermine'),
			'user' => GWF_User::getStaticOrGuest(),
			'termine' => $termine->selectObjects('*', $where, $orderby, self::IPP, $from),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Konzert&me=Termine&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Konzert&me=Termine&by=%BY%&dir=%DIR%&page=1',
		);
		return $this->_module->template('termine.tpl', $tVars);
	}
}
?>