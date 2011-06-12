<?php
/**
 * Ranking by Language
 * @author gizmore
 */
final class WeChall_RankingLang extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^lang_ranking/([a-z]{2})$ index.php?mo=WeChall&me=RankingLang&iso=$1'.PHP_EOL.
			'RewriteRule ^lang_ranking/([a-z]{2})/for/([^/]+)$ index.php?mo=WeChall&me=RankingLang&iso=$1&username=$2'.PHP_EOL.
			'RewriteRule ^lang_ranking/([a-z]{2})/page-(\d+)$ index.php?mo=WeChall&me=RankingLang&iso=$1&page=$2'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		if (false !== ($iso = Common::getPost('iso'))) {
			GWF_Website::redirect(GWF_WEB_ROOT.'lang_ranking/'.$iso);
			die();
		}
		
		if (false === ($lang = GWF_Language::getByISO(Common::getGet('iso')))) {
			if (false === ($lang = GWF_Language::getByISO('en'))) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
//		GWF_Website::addJavascript($module->getJSPath('wc.js'));
		
		if (false !== ($username = Common::getGet('username'))) {
			return $this->templateRankingFor($module, $lang, $username);
		}
		
		return $this->templateRanking($module, $lang, GWF_Session::getUser());
	}
	
	private function templateRankingFor(Module_WeChall $module, GWF_Language $lang, $username)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return $this->templateRanking($module, $lang, $user);
	}
	
	private function templateRanking(Module_WeChall $module, GWF_Language $lang, $user)
	{
		$db = gdo_db();
		$ipp = 50;
		$iso = $lang->getISO();
		$langid = $lang->getID();
		$users = GWF_TABLE_PREFIX.'user';
		$regat = GWF_TABLE_PREFIX.'wc_regat';

		# Count number of users playing this language.
		$query = "SELECT COUNT(DISTINCT regat_uid) AS c FROM $regat WHERE regat_langid=$langid AND regat_options&4=0";
		if (false === ($result = $db->queryFirst($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Page Menu
		$nItems = intval($result['c']);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		list($page, $hl_rank) = $this->getPageRank($langid, $ipp, $user);
		
		GWF_Website::setPageTitle($module->lang('pt_langrank', array($lang->displayName(), $page, $nPages)));
		GWF_Website::setMetaTags($module->lang('mt_ranking_lang', array($lang->displayName())));
		GWF_Website::setMetaDescr($module->lang('md_ranking_lang', array($lang->displayName(), $page, $nPages)));
		
//		echo 'PAGE:';
//		var_dump($page);
//		
//		echo 'RANK:';
//		var_dump($hl_rank);
//		
		$page = Common::clamp($page, 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		# Query Data
		$query =
			"SELECT r1.regat_uid AS user_id, user_name, user_level, user_countryid, r1.regat_sid, r1.regat_solved AS solved, r2.sum AS sum ".
			"FROM $regat AS r1 ".
			"JOIN (SELECT regat_uid,SUM(regat_score) AS sum FROM $regat WHERE regat_langid=$langid  GROUP BY regat_uid ORDER BY SUM(regat_score) DESC LIMIT $from,$ipp) AS r2 ON r1.regat_uid=r2.regat_uid ".
			"JOIN $users AS u ON u.user_id=r1.regat_uid ".
			"WHERE regat_options&4=0 ".
			"ORDER BY sum DESC ";
		if (false === ($result = $db->queryRead($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
//		var_dump($query);
		
		$data = array();
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$uid = intval($row['user_id']);
			if (!(isset($data[$uid]))) {
				$data[$uid] = new GWF_User($row);
			}
			$sid = $row['regat_sid'];
			$data[$uid]->setVar('ss_'.$sid, (double)$row['solved']);
		}
		$db->free($result);

		# Show template
		$tVars = array(
			'rank' => $from+1,
			'hlrank' => $hl_rank,
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'lang_ranking/'.$iso.'/page-%PAGE%'),
			'langname' => $lang->displayName(),
			'users' => $data,
			'sites' => WC_Site::getSitesLang($langid),
			'form_action' => $this->getMethodHref(),
			'iso' => $lang->getISO(),
		);
		return $module->templatePHP('ranking_lang.php', $tVars);
	}
	
	private function getPageRank($langid, $ipp, $user)
	{
//		return array(1,1);
		# We want a specific page...
		if (false !== ($page = Common::getGet('page'))) {
			$page = (int) $page;
			return array($page, ($page-1)*$ipp+1);
		}
		
		# Not logged in, so default is page1, rank1 (unless specified)
		if ($user === false || $user->isOptionEnabled(0x10000000)) {
			return array(1, 1);
		}
		
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		# Logged in, we show the current user
//		$query = 
//			"SELECT SUM(regat_score) FROM $regat WHERE regat_uid=$userid HAVING regat_langid=$langid;";	 
//		$query = "SELECT COUNT(*) AS c FROM gwf_wc_regat GROUP BY regat_uid WHERE SUM(regat_score)>1234 HAVING regat_langid=1";
		
//		$query = "SELECT COUNT(*) AS c FROM $regat WHERE regat_langid=$langid GROUP BY regat_uid HAVING SUM(regat_score) > 1234";
		
//		$query = "SELECT v1a.userid, COUNT(v1b.userid) AS cnt FROM v1 AS v1a JOIN v1 AS v1b ON (v1a.total, v1a.userid) <= (v1b.total, v1b.userid) GROUP BY v1a.userid ORDER BY cnt ASC"
//		$query = "SELECT v1a.regat_uid, COUNT(v1b.regat_uid) AS cnt FROM $regat AS v1a JOIN $regat AS v1b ON (SUM(regat_score), v1a.regat_uid) <= (SUM(regat_score), v1b.userid) GROUP BY v1a.regat_uid ORDER BY cnt ASC";
//		SELECT regat_onsitename, SUM(regat_score) AS total FROM gwf_wc_regat WHERE regat_langid=1 GROUP BY regat_uid, regat_langid ORDER BY total DESC LIMIT 3;
		
//		$query = "SELECT regat_uid, SUM(regat_score) AS total FROM gwf_wc_regat WHERE regat_langid=1 GROUP BY regat_uid ORDER BY total DESC LIMIT 1;";
//		$query = "SELECT COUNT(*) AS c FROM $regat AS r1 JOIN (SELECT SUM(regat_score) AS total FROM gwf_wc_regat WHERE regat_langid=1 GROUP BY regat_uid) AS r2 WHERE total>1234";
//		$query = "SELECT COUNT(*) FROM $regat WHERE SUM(regat_score) > 80000 GROUP BY regat_uid HAVING regat_langid=1";
		
		# YAY \o/ 
		#SELECT SUM(regat_score) FROM gwf_wc_regat WHERE regat_langid=1 GROUP BY regat_uid HAVING SUM(regat_score)>180000;
		$db = gdo_db();
		$userid = $user->getID();
		$query = "SELECT SUM(regat_score) FROM $regat WHERE regat_langid=$langid AND regat_uid=$userid";
		if (false === ($result = $db->queryFirst($query, false))) {
			return array(1, 1);
		}
		if ($result[0] === NULL) {
			return array(1, 1);
		}
		$score = $result[0];
		
		$query = "SELECT SUM(regat_score) FROM $regat WHERE regat_langid=$langid GROUP BY regat_uid HAVING (SUM(regat_score)>($score)) OR (SUM(regat_score)=($score) AND regat_uid<$userid)";
		if (false === ($result = $db->queryRead($query))) {
			return array(1, 1);
		}
		$rank = $db->numRows($result)+1;
//		$rank = intval($result['c'])+1;
		$page = GWF_PageMenu::getPageForPos($rank, $ipp);
		return array($page, $rank);
	}
}
?>