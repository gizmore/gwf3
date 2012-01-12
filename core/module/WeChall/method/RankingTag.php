<?php

final class WeChall_RankingTag extends GWF_Method
{
	const DEFAULT_TAG = 'Exploit';
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^category_ranking$ index.php?mo=WeChall&me=RankingTag'.PHP_EOL.
			'RewriteRule ^category_ranking/([^/]+)$ index.php?mo=WeChall&me=RankingTag&tag=$1'.PHP_EOL.
			'RewriteRule ^category_ranking/([^/]+)/page-(\d+)$ index.php?mo=WeChall&me=RankingTag&tag=$1&page=$2'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== Common::getPost('quickjmp')) {
			return $this->onQuickjump();
		}
		return $this->templateRanking();
	}
	
	private function onQuickjump()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteCats.php';
		if (false === ($cat = WC_SiteCats::getCatForBit(Common::getPost('category')))) {
			$location = GWF_WEB_ROOT.'category_ranking';
		}
		else {
			$location = GWF_WEB_ROOT.'category_ranking/'.urlencode($cat);
		}
		header('Location: '.$location);
		return '';
	}
	
	private function templateRanking()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteCats.php';
		
		$tag = Common::getGet('tag', self::DEFAULT_TAG);
		if (0 === ($bit = WC_SiteCats::getBitForCat($tag))) {
			$bit = 1;
			$tag = $_GET['tag'] = WC_SiteCats::getCatForBit($bit);
		}
		
		$ipp = 50;
		$nItems = $this->countItems($bit);
		
		list($page, $hlrank) = $this->getPageNum($ipp, $bit);
		
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp($page, 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$rank = ($page-1) * $ipp + 1;
		
		$data = $bit === 0 ? array() : $this->selectPage($bit, $from, $ipp);
		
		$dtag = GWF_HTML::display($tag);
		
		GWF_Website::setPageTitle($this->_module->lang('pt_tagrank', array($dtag)));
		GWF_Website::setMetaTags($this->_module->lang('mt_tagrank', array($dtag, $dtag)));
		GWF_Website::setMetaDescr($this->_module->lang('md_tagrank', array($dtag, $page, $nPages)));
		
		$tVars = array(
			'rank' => $rank,
			'hlrank' => $hlrank,
			'sites' => WC_Site::getSimilarSitesS($bit, true),
			'data' => $data,
			'tag' => $dtag,
			'form_action' => GWF_WEB_ROOT.'category_ranking',
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('category_ranking/%s/page-%%PAGE%%', urlencode($tag))),
			'select' => $this->getTagSelect(),
		);
		return $this->_module->templatePHP('ranking_tag.php', $tVars);
	}
	
	private function getPageNum($ipp, $bit)
	{
		if ( (false !== ($user = GWF_Session::getUser())) && (!$user->isWebspider()) && !$user->isOptionEnabled(0x10000000)) {
			if (false !== ($page = Common::getGet('page'))) {
				$hlrank = (($page-1)*$ipp) + 1;
			}
			else {
//				$page = Common::getGet('page', 1);
				$hlrank = $this->calcRank($user, $bit);
				$page = GWF_PageMenu::getPageForPos($hlrank, $ipp);
			}
		}
		else {
			$page = Common::getGet('page', 1);
			$hlrank = 1;
		}
		return array($page, $hlrank);
	}
	
	private function calcScore(GWF_User $user, $bit)
	{
		$db = gdo_db();
		$bit = (int) $bit;
		$uid = $user->getVar('user_id');
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = "SELECT SUM(regat_score) s FROM $regat WHERE regat_uid=$uid AND regat_tagbits&$bit";
		if (false === ($result = $db->queryFirst($query))) {
			return -1;
		}
		return (int)$result['s'];
	}
	
	private function calcRank(GWF_User $user, $bit)
	{
		$db = gdo_db();
		$bit = (int) $bit;
		$uid = $user->getVar('user_id');
		$score = $this->calcScore($user, $bit);
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = "SELECT regat_uid, SUM(regat_score) AS sum FROM $regat WHERE regat_tagbits&$bit GROUP BY regat_uid HAVING sum>$score OR (sum=$score AND regat_uid<$uid)";
		if (false === ($result = $db->queryRead($query, false))) {
			return -1;
		}
		$back = (int) $db->numRows($result);
		$db->free($result);
		return $back + 1;
	}
	
	private function selectPage($bit, $from, $ipp)
	{
		$db = gdo_db();
		$users = GWF_TABLE_PREFIX.'user';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = 
			"SELECT user_id, user_name, user_level, user_countryid, B.sum, regat_sid, regat_score, regat_solved ".
			"FROM $regat AS A ".
			"JOIN (SELECT regat_uid, SUM(regat_score) AS sum FROM $regat WHERE regat_tagbits&$bit GROUP BY regat_uid ORDER BY sum DESC LIMIT $from, $ipp) AS B ON A.regat_uid = B.regat_uid ".
			"JOIN $users AS U on user_id=A.regat_uid ".
			"WHERE regat_options&4=0 ".
			"ORDER BY sum DESC";
		
		$back = array();
		if (false === ($result = $db->queryRead($query))) {
			return $back;
		}
		
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$uid = (int) $row['user_id'];
			if (!isset($back[$uid])) {
				$back[$uid] = new GWF_User($row);
			}
			$sid = $row['regat_sid'];
			$back[$uid]->setVar('ss_'.$sid, $row['regat_solved']);
		}
		
		$db->free($result);
		
		return $back;
	}
	
	private function countItems($bit)
	{
		$db = gdo_db();
		$bit = (int) $bit;
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = "SELECT COUNT(DISTINCT(regat_uid)) c FROM $regat WHERE regat_tagbits&$bit AND regat_options&4=0";
		if (false === ($result = $db->queryFirst($query))) {
			return 0;
		}
		return (int) $result['c'];
	}

	private function getTagSelect(GWF_Module $module)
	{
		$db = gdo_db();
		$cats = GWF_TABLE_PREFIX.'wc_sitecat';
		$query = "SELECT DISTINCT sitecat_bit, sitecat_name FROM $cats ORDER BY sitecat_name ASC";
		if (false === ($result = $db->queryRead($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$sel = Common::getGetString('tag', self::DEFAULT_TAG);
		$selbit = '0';
		$back = '';
		$data = array();
		while (false !== ($row = $db->fetchRow($result)))
		{
			$bit = $row[0];
			$tag = $row[1];
			
			$data[] = array($bit, $tag);
			
			if ($tag === $sel)
			{
				$selbit = $bit;
			}
		}
		$db->free($result);
		$onchange = "document.location = GWF_WEB_ROOT+'category_ranking/'+this.options[this.selectedIndex].text;";
		return GWF_Select::display('category', $data, $selbit, $onchange);
		
	}
}

?>