<?php
/**
 * Site Ranking
 * @author gizmore
 */
final class WeChall_SiteRankings extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^site/ranking/for/(\d+)/[^/]+$ index.php?mo=WeChall&me=SiteRankings&sid=$1'.PHP_EOL.
			'RewriteRule ^site/ranking/for/(\d+)/[^/]+/page-(\d+)$ index.php?mo=WeChall&me=SiteRankings&sid=$1&page=$2'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== (Common::getPost('quickjump'))) {
			return $this->onQuickjump($this->_module);
		}
		
		return $this->templateRanking($this->_module);
	}
	
	private function getLinkcountUnranked($siteid)
	{
		$siteid=(int)$siteid;
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		return GDO::table('WC_RegAt')->countRows("regat_sid={$siteid} AND regat_options&4=1");
	}
	
	public function templateRanking()
	{
		if (false === ($site = WC_Site::getByID(Common::getGet('sid')))) {
			return $this->_module->error('err_site');
		}
		
		$ipp = $this->_module->cfgItemsPerPage();
		$nItems = $site->getLinkcount() - $this->getLinkcountUnranked($site->getID());
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);

		$args = array($site->displayName(), $page);
		$title = $this->_module->lang('pt_site_ranking', $args);
		
		GWF_Website::setPageTitle($title);
		GWF_Website::setMetaTags($this->_module->lang('mt_site_ranking', $args));
		GWF_Website::setMetaDescr($this->_module->lang('md_site_ranking', $args));
		
		$tVars = array(
			'userdata' => $this->getRankedUsers($this->_module, $site, $from, $ipp),
			'site' => $site,
			'sites' => $site->getSimilarSites(),
			'site_quickjump' => $this->_module->templateSiteQuickjumpRanking(),
			'rank' => $from+1,
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'site/ranking/for/'.$site->getID().'/'.$site->urlencodeSEO('site_name').'/page-%PAGE%'),
			'page_title' => $title,
		);
		return $this->_module->templatePHP('site_ranking.php', $tVars);
	}
	
//	private function getRankedUsersOLD(Module_WeChall $module, WC_Site $site, $from, $ipp)
//	{
//		$db = gdo_db();
//		$regat = GDO::table('WC_RegAt')->getTableName();
//		$users = GDO::table('GWF_User')->getTableName();
//		$siteid = $site->getID();
//		$query = "SELECT regat_onsitescore,regat_options,u.user_name,u.user_level,u.user_countryid FROM $regat AS r JOIN $users AS u ON u.user_id=r.regat_uid WHERE r.regat_sid=$siteid ORDER BY regat_onsitescore DESC LIMIT $from, $ipp";
//		if (false === ($result = $db->queryAll($query))) {
//			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
//			return array();
//		}
//		return $result;
//	}
//	
//	private function getRankedUsersOLD2(Module_WeChall $module, WC_Site $site, $from, $ipp)
//	{
//		$db = gdo_db();
//		$sid1 = $site->getVar('site_id');
//		$bits = $site->getTagBits();
//		$users = GWF_TABLE_PREFIX.'user';
//		$regat = GWF_TABLE_PREFIX.'wc_regat';
//		$query =
//			"SELECT r1.regat_uid AS user_id, user_name, user_level, user_countryid, r1.regat_sid, r1.regat_solved, r1.regat_score, IF(r1.regat_sid=$sid1, r1.regat_score, -1) AS score3 ".
//			"FROM $regat AS r1 ".
//			"JOIN (SELECT regat_uid, IF(regat_sid=$sid1, regat_score, -1) AS score2 FROM $regat WHERE regat_tagbits&$bits GROUP BY regat_uid ORDER BY score2 DESC LIMIT $from,$ipp) AS r2 ON r1.regat_uid=r2.regat_uid ".
//			"JOIN $users AS u ON u.user_id=r1.regat_uid ".
//			"ORDER BY score3 DESC ";
//		
//		echo $query;
//		if (false === ($result = $db->queryRead($query))) {
//			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
//			return array();
//		}
//		$back = array();
//		while (false !== ($row = $db->fetchAssoc($result)))
//		{
//			$uid = intval($row['user_id']);
//			if (!(isset($back[$uid]))) {
//				$back[$uid] = new GWF_User($row);
//				$back[$uid]->setVar('regat_solved', '0');
//			}
//			$sid = $row['regat_sid'];
//			$back[$uid]->setVar('site_'.$sid, $row['regat_solved']);
//			
//			if ($sid === $sid1) {
//				$back[$uid]->setVar('regat_solved', $row['regat_solved']);
//			}
//		}
//		$db->free($result);
//		return $back;
//	}

	private function getRankedUsers(Module_WeChall $module, WC_Site $site, $from, $ipp)
	{
		$db = gdo_db();
		$sid = $site->getVar('site_id');
		$bits = $site->getTagBits();
		$users = GWF_TABLE_PREFIX.'user';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = 
			"SELECT user_id, user_name, user_countryid, user_level, regat_solved, regat_onsiterank, regat_score ".
			"FROM $regat ".
			"JOIN $users ON user_id=regat_uid ".
			"WHERE regat_sid=$sid AND regat_options&4=0 ".
			"ORDER BY regat_solved DESC, user_level DESC ".
			"LIMIT $from, $ipp";
		if (false === ($result = $db->queryRead($query))) {
			return array();
		}
		
		$back = array();
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$back[] = $this->getUserStuff($row, $db, $bits);
		}
		$db->free($result);
		return $back;
	}
	
	private function getUserStuff(array $row, GDO_Database $db, $bits)
	{
		$back = new GWF_User($row);
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$uid = $row['user_id'];
		$query = "SELECT regat_sid, regat_solved FROM $regat WHERE regat_uid=$uid AND regat_tagbits&$bits AND regat_options&4=0";
		if (false === ($result = $db->queryRead($query))) {
			return $back;
		}
		while (false !== ($row = $db->fetchRow($result)))
		{
			$back->setVar('site_'.$row[0], $row[1]);
		}
		$db->free($result);
		return $back;
	}

	### Quickjump
	private function onQuickjump()
	{
		$jumps = Common::getPost('quickjumps');
		if (!is_array($jumps)) {
			return $this->_module->error('err_site').'1';
		}
		
		foreach ($jumps as $key => $value)
		{
			if ($value === '0') {
				continue;
			}
			
			if (false === ($site = WC_Site::getByID($value))) {
				return $this->_module->error('err_site').'2';
			}

			$sid = $site->getVar('site_id');
			GWF_Website::redirect(GWF_WEB_ROOT.'site/ranking/for/'.$site->urlencode2('site_name'));
			return '';
		}

		return $this->_module->error('err_site').'3';
	}
}

?>