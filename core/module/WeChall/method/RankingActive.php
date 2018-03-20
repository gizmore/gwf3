<?php
/**
 * Ranking
 * @author gizmore
 * @version 1.0
 */
final class WeChall_RankingActive extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^ranking_active$ index.php?mo=WeChall&me=RankingActive'.PHP_EOL.
			'RewriteRule ^ranking_active/player/([^/]+)$ index.php?mo=WeChall&me=RankingActive&username=$1'.PHP_EOL.
			'RewriteRule ^ranking_active/page-(\d+)/?$ index.php?mo=WeChall&me=RankingActive&page=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($username = Common::getGet('username'))) {
			return $this->templateRankingU($username);
		}
		
		return $this->templateRanking(GWF_Session::getUser());
	}
	
	private function templateRankingU($username)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return $this->templateRanking($user);
	}
	
	private function templateRanking($user)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		$users = GDO::table('GWF_User');
		$ipp = $this->module->cfgItemsPerPage();
		$nItems = $users->countRows("user_level>0");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		
		if (false === ($page = Common::getGet('page'))) {
			list($page, $rank) = $this->getPageForSession($ipp, $user);
		} else {
			$page = Common::clamp(intval($page), 1, $nPages);
// 			$rank = $user === false || $user->isOptionEnabled(0x10000000) ? 1 : $this->calcExactRank($user);
		}
		
//		var_dump($page);
//		var_dump($rank);
		
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$href = GWF_WEB_ROOT.'ranking_active/page-%PAGE%';
		
		GWF_Website::setPageTitle($this->module->lang('pt_ranking', array($page)));
		GWF_Website::setMetaTags($this->module->lang('mt_ranking'));
		
		$userdata = $this->selectUsers($ipp, $from);
		
		$tVars = array(
			'rank' => $from+1,
			'highlight_rank' => 1,
			'sites' => $this->getSites(),
			'userdata' => $userdata,
			'page_menu' => GWF_PageMenu::display($page, $nPages, $href),
		);
		return $this->module->templatePHP('ranking_active.php', $tVars);
	}
	
	private function getSites()
	{
		return WC_Site::table('WC_Site')->selectAll('*', "site_status='up'", 'site_id ASC', null, -1, -1, GDO::ARRAY_O);
	}
	
	public function getPageForSession($ipp, $user)
	{
		if ($user === false || $user->isWebspider() || $user->isOptionEnabled(0x10000000)) {
			return array(1, 1);
		}
		return array(1,1); # FIX SLOW
		
// 		$rank = $this->calcExactRank($user);
// 		$page = GWF_PageMenu::getPageForPos($rank, $ipp);
// 		return array($page, $rank);
	}
			
			
// 	private function calcScore(GWF_User $user)
// 	{
// 		$db = gdo_db();
// 		$regat = GDO::table('WC_RegAt')->getTableName();
// 		$sites = GDO::table('WC_Site')->getTableName();
// 		$query = "SELECT SUM(regat_score) AS sum ".
// 				"FROM $regat R ".
// 				"JOIN $sites S ON S.site_id = R.regat_sid ".
// 				"WHERE regat_uid={$user->getID()} AND site_status='up'";
// 		$result = $db->queryFirst($query);
// 		return $result['sum'];
// 	}
	
// 	private function calcExactRank(GWF_User $user)
// 	{
// 		$score = $this->calcScore($user);
		
// 		$db = gdo_db();
// 		$regat = GDO::table('WC_RegAt')->getTableName();
// 		$sites = GDO::table('WC_Site')->getTableName();
		
// 		$query = "SELECT regat_uid, SUM(regat_score) AS sum".
// 				" FROM $regat AS B".
// 				" JOIN $sites AS S ON B.regat_sid = S.site_id".
// 				" WHERE site_status = 'up'".
// 				" GROUP by regat_uid".
// 				" HAVING sum>$score".
// 				"";
// 		$result = $db->queryRead($query);
// 		return $db->numRows($result) + 1;
// 	}
	
	/**
	 * Select Users For Global Ranking.
	 * @param int $count
	 * @param int $from
	 * @return array
	 */
	private function selectUsers($count, $from)
	{
		$db = gdo_db();
		$count = (int) $count;
		$from = (int) $from;
		$regat = GDO::table('WC_RegAt')->getTableName();
		$users = GDO::table('GWF_User')->getTableName();
		$sites = GDO::table('WC_Site')->getTableName();
		$query = "SELECT regat_uid as user_id, user_name, SUM(regat_score) AS user_level,".
		" GROUP_CONCAT(regat_sid) AS site_ids,".
		" GROUP_CONCAT(regat_solved) AS site_solveds, ".
		" COUNT(regat_score) AS nlinks, user_countryid".
		" FROM $regat AS B".
		" JOIN $sites AS S ON B.regat_sid = S.site_id".
		" JOIN $users AS U ON B.regat_uid = U.user_id".
		" WHERE site_status = 'up' AND U.user_level > 0".
		" GROUP by user_id".
// 		" HAVING user_level > 0".
		" ORDER BY user_level DESC, user_id ASC".
		" LIMIT $from, $count";
		$back = array();
		if (false === ($result = $db->queryRead($query))) {
			return $back;
		}
		
		$current = false;
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$current = new GWF_User($row);
			$sids = explode(',', $current->getVar('site_ids'));
			$sols = explode(',', $current->getVar('site_solveds'));
			foreach ($sids as $i => $sid)
			{
				$current->setVar('ss_'.$sid, $sols[$i]);
			}
			$back[] = $current;
		}			
		
		$db->free($result);
		return $back;
	}
}
