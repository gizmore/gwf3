<?php
final class WeChall_WarflagSolvers extends GWF_Method
{
	/**
	 * @var WC_Warflag
	 */
	private $flag;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^(\d+)-solvers-for- /index.php?mo=WeChall&me=WarflagSolvers&flag=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_Warflags');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
		
		if (false === ($this->flag = WC_Warflag::getByID(Common::getGetString('flag'))))
		{
			return $this->module->error('err_warflag');
		}
		
		return $this->templateSolvers();
	}
	
	private function templateSolvers()
	{
		$box = $this->flag->getWarbox();
		$_GET['sid'] = $box->getSiteID();
		$_GET['bid'] = $box->getID();
		
		$fid = $this->flag->getID();
		$table = GDO::table('WC_Warflags');

		$where = "wf_id={$fid}";
		$orderby = 'wf_solved_at ASC';
		$joins = array('flag', 'solvers', 'flagbox', 'flagsite');
		$ipp = 50;
		$nItems = $table->countRows($where, $joins);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$tVars = array(
			'site_quickjump' => $this->module->templateSiteQuickjump('boxdetail'),
			'solvers' => $table->selectAll('*', $where, $orderby, $joins, $ipp, $from, GDO::ARRAY_A),
			'flag' => $this->flag,
			'rank' => $from+1,
			'sort_url' => NULL,
			'solvercount' => $nItems,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT."index.php?mo=WeChall&me=WarflagSolvers&flag={$fid}&page=%PAGE%"),
		);
		return $this->module->templatePHP('warflag_solvers.php', $tVars);
	}
}