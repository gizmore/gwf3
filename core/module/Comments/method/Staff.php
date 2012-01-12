<?php
final class Comments_Staff extends GWF_Method
{
	const DEFAULT_BY = 'cmts_id';
	const DEFAULT_DIR = 'ASC';
	
	public function getUserGroups() { return array(GWF_Group::STAFF); }
	
	public function execute()
	{
		return $this->templateStaff();
	}
	
	private function templateStaff()
	{
		$table = GDO::table('GWF_Comments');
		$where = $this->getWhere();
		$ipp = 25;
		$nItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$by = Common::getGetString('by', self::DEFAULT_BY);
		$dir = Common::getGetString('dir', self::DEFAULT_DIR);
		$orderby = $table->getMultiOrderby($by, $dir);
		
		$hrefp = GWF_WEB_ROOT.sprintf('index.php?mo=Comments&me=Staff&by=%s&dir=%s&mode=%s&page=%%PAGE%%', urlencode($by), urlencode($dir), urlencode(Common::getGetString('mode')));
		
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $hrefp),
			'comments' => $table->selectObjects('*', $where, $orderby, $ipp, $from),
		);
		return $this->_module->template('staff.tpl', $tVars);
	}
	
	private function getWhere()
	{
		switch (Common::getGetString('mode'))
		{
			case 'disabled': return '';
			case 'deleted': return '';
			default: return '';
		}
	}
}
?>