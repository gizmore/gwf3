<?php
final class Audit_Logs extends GWF_Method
{
	const IPP = 25;
	const DEFAULT_BY = 'al_id';
	const DEFAULT_DIR = 'DESC';
	
	public function getUserGroups() { return array(GWF_Group::STAFF); }
	
	public function execute()
	{
		return $this->templateLogs();
	}
	
	private function templateLogs()
	{
		$ipp = self::IPP;
		$where = "al_type='script'";
		$whitelist = array('size');
		$table = GDO::table('GWF_AuditLog');
		$nRows = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nRows);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$by = Common::getGetString('by', self::DEFAULT_BY);
		$dir = Common::getGetString('dir', self::DEFAULT_DIR);
		$orderby = $table->getMultiOrderby($by, $dir, true, $whitelist);
		
		$tVars = array(
			'logs' => $table->selectAll('al_id,al_eusername,al_username,al_time_start,al_time_end,al_rand,LENGTH(al_data) size, al_id, al_id+1', $where, $orderby, NULL, $ipp, $from, GDO::ARRAY_N),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Audit&me=Logs&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Audit&me=Logs&by=%BY%&dir=%DIR%&page=1',
		);
		
		return $this->_module->template('logs.tpl', $tVars);
	}
}
?>