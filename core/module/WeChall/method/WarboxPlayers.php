<?php
final class WeChall_WarboxPlayers extends GWF_Method
{
	/**
	 * @var WC_Warbox
	 */
	private $box;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^(\d+)-players-on- /index.php?mo=WeChall&me=WarboxPlayers&boxid=$1'.PHP_EOL;
	}

	public function execute()
	{
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_Warflags');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
		
		if (isset($_POST['wc_boxes_quickjump']))
		{
			$_GET['boxid'] = Common::getPostString('wc_boxes_quickjump');
		}
		
		if (false === ($this->box = WC_Warbox::getByID(Common::getGetString('boxid'))))
		{
			return $this->module->error('err_warbox');
		}
		
		return $this->templatePlayers();
	}
	
	private function templatePlayers()
	{
		$bid = $this->box->getID();
		
		$_GET['sid'] = $this->box->getSiteID();
		$_GET['bid'] = $bid;
		
		$table = GDO::table('WC_Warflags');
		$where = "wf_wbid={$bid} AND wf_solved_at IS NOT NULL";
		$orderby = 'score DESC, solvedate ASC';
		$joins = array('flag', 'flagbox', 'solvers');
		$ipp = 50;
		$nItems = $table->countRows($where, $joins, 'user_name');
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$tVars = array(
			'site_quickjump' => $this->module->templateSiteQuickjump('boxranking'),
			'data' => $table->selectAll("user_name, user_countryid country, COUNT(*) solved, SUM(wf_score) score, SUM(wf_score)/{$this->box->getVar('wb_totalscore')}*100 percent, MAX(wf_solved_at) solvedate", $where, $orderby, $joins, $ipp, $from, GDO::ARRAY_A, 'user_name'),
			'box' => $this->box,
			'playercount' => $nItems,
			'rank' => $from+1,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=WeChall&me=WarboxPlayers&boxid='.$bid.'&page=%PAGE%'),
		);
		return $this->module->templatePHP('warbox_players.php', $tVars);
	}
}
?>