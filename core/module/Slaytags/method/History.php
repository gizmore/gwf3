<?php
final class Slaytags_History extends GWF_Method
{
	public function execute()
	{
		return $this->templateHistory();
	}
	
	private function templateHistory()
	{
		$table = GDO::table('Slay_PlayHistory');
		$ipp = Slay_PlayHistory::IPP;
		$where = '';
		$nItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$tVars = array(
			'is_admin' => GWF_User::isStaffS(),
			'page' => $page,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Slaytags&me=History&page=%PAGE%'),
			'history' => $table->selectAll('*', $where, 'sph_date ASC', array('songs'), $ipp, $from, 'Slay_Song'),
		);
		return $this->_module->template('history.tpl', $tVars);
	}
}
?>