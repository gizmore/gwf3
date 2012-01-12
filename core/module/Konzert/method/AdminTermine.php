<?php
final class Konzert_AdminTermine extends GWF_Method
{
	const DEFAULT_BY = 'kt_date';
	const DEFAULT_DIR = 'ASC';
	const IPP = 20;
	
	public function getUserGroups() { return array('admin','staff'); }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateTermine($this->_module);
	}
	
	private function templateTermine(Module_Konzert $module)
	{
		$termine = GDO::table('Konzert_Termin');
		
		$where = '';
		
		$by = Common::getGetString('by', self::DEFAULT_BY);
		$dir = Common::getGetString('dir', self::DEFAULT_DIR);
		$orderby = $termine->getMultiOrderby($by, $dir);
		
		$nItems = $termine->countRows($where);
		$nPages = GWF_PageMenu::getPagecount(self::IPP, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, self::IPP);
		
		$tVars = array(
			'add_button' => GWF_Button::add($this->_module->lang('btn_add'), $this->_module->getMethodURL('AddTermin')),
			'termine' => $termine->selectObjects('*', $where, $orderby, self::IPP, $from),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Konzert&me=AdminTermine&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Konzert&me=AdminTermine&by=%BY%&dir=%DIR%&page=1',
		);
		
		return $this->_module->template('a_termine.tpl', $tVars);
	}
}
?>