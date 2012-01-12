<?php
/**
 * Ranking
 * @author gizmore
 * @version 1.0
 */
final class WeChall_Ranking extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^ranking$ index.php?mo=WeChall&me=Ranking'.PHP_EOL.
			'RewriteRule ^ranking/player/([^/]+)$ index.php?mo=WeChall&me=Ranking&username=$1'.PHP_EOL.
			'RewriteRule ^ranking/page-(\d+)$ index.php?mo=WeChall&me=Ranking&page=$1'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		if (false !== ($username = Common::getGet('username'))) {
			return $this->templateRankingU($this->_module, $username);
		}
		
		return $this->templateRanking($this->_module, GWF_Session::getUser());
	}
	
	private function templateRankingU(Module_WeChall $module, $username)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return $this->templateRanking($this->_module, $user);
	}
	
	private function templateRanking(Module_WeChall $module, $user)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		$users = GDO::table('GWF_User');
		$ipp = $this->_module->cfgItemsPerPage();
		$nItems = $users->countRows("user_level>0");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		
		if (false === ($page = Common::getGet('page'))) {
			list($page, $rank) = $this->getPageForSession($ipp, $user);
		} else {
			$page = Common::clamp(intval($page), 1, $nPages);
			$rank = $user === false || $user->isOptionEnabled(0x10000000) ? 1 : WC_RegAt::calcExactRank($user);
		}
		
//		var_dump($page);
//		var_dump($rank);
		
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$href = GWF_WEB_ROOT.'ranking/page-%PAGE%';
		
		GWF_Website::setPageTitle($this->_module->lang('pt_ranking', array($page)));
		GWF_Website::setMetaTags($this->_module->lang('mt_ranking'));
		
		$userdata = $this->selectUsers($ipp, $from);
		
		$tVars = array(
			'rank' => $from+1,
			'highlight_rank' => $rank,
			'langs' => WC_Site::getLangs(),
//			'isos' => WC_Site::getLangISOs(),
			'userdata' => $userdata,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href),
		);
		return $this->_module->templatePHP('ranking.php', $tVars);
	}
	
	public function getPageForSession($ipp, $user)
	{
		if ($user === false || $user->isWebspider() || $user->isOptionEnabled(0x10000000)) {
			return array(1, 1);
		}
		$rank = WC_RegAt::calcExactRank($user);
		$page = GWF_PageMenu::getPageForPos($rank, $ipp);
		return array($page, WC_RegAt::calcRank($user));
	}
			
			
			
			
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
		$query = "SELECT user_id,user_name,user_level,SUM(regat_score) AS lts, COUNT(regat_score) AS nlinks, regat_langid,user_countryid FROM $regat AS B JOIN (SELECT user_id,user_name,user_level,user_countryid FROM $users WHERE user_options&0x10000000=0 ORDER BY user_level DESC, user_id ASC LIMIT $from, $count) AS C ON user_id=regat_uid GROUP by user_id,regat_langid ORDER BY user_level DESC, user_id ASC";
		$back = array();
		if (false === ($result = $db->queryRead($query))) {
			return $back;
		}
		
		$current = false;
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			if ($current === false) {
				$current = new GWF_User($row);
				$current->setVar('nlinks', 0);
				$back[] = $current;
			}
			elseif ($current->getVar('user_id') !== $row['user_id']) {
				if (count($back) === $count) {
					break;
				}
				$current = new GWF_User($row); 
				$current->setVar('nlinks', 0);
				$back[] = $current;
			}
			$current->setVar('grank_'.$row['regat_langid'], $row['lts']);
			$current->setVar('nlinks', $current->getVar('nlinks') + $row['nlinks']);
//			var_dump($current->getGDOData());
		}			
		
		$db->free($result);
		
//		var_dump($back);
		return $back;
	}
}

?>
