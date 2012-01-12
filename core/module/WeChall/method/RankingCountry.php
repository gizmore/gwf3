<?php

final class WeChall_RankingCountry extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^country_ranking$ index.php?mo=WeChall&me=RankingCountry'.PHP_EOL.
			'RewriteRule ^country_ranking/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=RankingCountry&by=$1&dir=$2&page=$3'.PHP_EOL.
			'RewriteRule ^country_ranking/for/(\d+)/[^/]+$ index.php?mo=WeChall&me=RankingCountry&cid=$1'.PHP_EOL.
			'RewriteRule ^country_ranking/for/(\d+)/[^/]+/page-(\d+)$ index.php?mo=WeChall&me=RankingCountry&cid=$1&page=$2'.PHP_EOL.
			'RewriteRule ^country_ranking/player/([^/]+)$ index.php?mo=WeChall&me=RankingCountry&username=$1'.PHP_EOL.
			'';
	}
	public function execute()
	{
		if (false !== ($username = Common::getGet('username'))) {
			return $this->templateSingleU($this->_module, $username);
		}
		if (false !== ($cid = Common::getGet('cid'))) {
			return $this->templateSingle($this->_module, $cid, GWF_Session::getUser());
		}
		
		GWF_Website::setPageTitle($this->_module->lang('pt_csrank'));
		GWF_Website::setMetaTags($this->_module->lang('mt_csrank'));
		GWF_Website::setMetaDescr($this->_module->lang('md_csrank'));
		return $this->templateRanking($this->_module);
	}
	
	private function templateRanking()
	{
		$whitelist = array('countryname','totalscore','users','avg','top3','topuser','spc');
		$by = GDO::getWhitelistedByS(Common::getGet('by', 'avg'), $whitelist, 'avg');
		$dir = GDO::getWhitelistedDirS(Common::getGet('dir', 'DESC'), 'DESC');
		
		$users = GWF_TABLE_PREFIX.'user';
		$countries = GWF_TABLE_PREFIX.'country';
		$hide_ranking = 'AND user_options&0x10000000=0';
		$query = 
			"SELECT ".
			"`c`.`country_id`, ".
			"`c`.`country_name` AS `countryname`, ".
			"COUNT(`user_id`) AS `users`, ".
			"(SELECT `user_name` FROM `$users` WHERE `user_countryid`=country_id $hide_ranking ORDER BY `user_level` DESC LIMIT 1) AS `topuser`, ".
			"MAX(`user_level`) as `topscore`, ".
			"AVG(`u`.`user_level`) AS `avg`, ".
			"SUM(`user_level`) AS `totalscore`, ".
				"MAX(`user_level`) + ".
				"IFNULL((SELECT `user_level` FROM `$users` AS `u2` WHERE `u2`.`user_countryid`=`country_id` $hide_ranking ORDER BY `user_level` DESC LIMIT 1,1), 0) +".
				"IFNULL((SELECT `user_level` FROM `$users` AS `u2` WHERE `u2`.`user_countryid`=`country_id` $hide_ranking ORDER BY `user_level` DESC LIMIT 2,1), 0) ".
			"AS `top3`, ".
			'ROUND(SUM(`user_level`) / `c`.`country_pop` * 1000, 2) AS `spc` '.
			"FROM `$countries` AS `c` ".
			"JOIN `$users` AS `u` ON `u`.`user_countryid` = `c`.`country_id` ".
			"WHERE `c`.`country_id` > 0 ".#$hide_ranking ".
			"GROUP BY `country_id` ".
			"ORDER BY $by $dir; ";
		
//		echo "$query<br/>";
		
		$db = gdo_db();
		
		if (false === ($result = $db->queryAll($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$tVars = array(
			'highlight_country' => $this->getHighlightCountry(), 
			'data' => $result,
			'sort_url' => GWF_WEB_ROOT.'country_ranking/by/%BY%/%DIR%/page-1',
		);
		return $this->_module->templatePHP('ranking_countries.php', $tVars);
	}
	
	private function getHighlightCountry()
	{
		if (
			(false === ($user = GWF_Session::getUser())) ||
			('0' === ($cid = $user->getVar('user_countryid')))
		)
		{
			return GWF_IP2Country::detectCountryID();
		}
		else
		{
			return $cid;
		}
	}
	
	#############################
	### Single Country Detail ###
	#############################
	private function templateSingleU(Module_WeChall $module, $username)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		return $this->templateSingle($this->_module, $user->getCountryID(), $user);
	}
	
	private function templateSingle(Module_WeChall $module, $cid, $user)
	{
		if (false === ($country = GWF_Country::getByID($cid))) {
			return GWF_HTML::err('ERR_UNKNOWN_COUNTRY');
		}
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';

		$cid = $country->getID();
		$ipp = 50;
		$nItems = GDO::table('GWF_User')->countRows("user_countryid=$cid");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		
		list($page, $hlrank) = $this->getSinglePageRank($cid, $ipp, $user);

		$page = Common::clamp($page, 1, $nPages);
		$rank = ($page-1) * $ipp + 1;
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$cname = $country->display('country_name');

		GWF_Website::setPageTitle($this->_module->lang('pt_crank', array($cname, $page)));
		GWF_Website::setMetaTags($this->_module->lang('mt_crank', array($cname, $cname)));
		GWF_Website::setMetaDescr($this->_module->lang('md_crank', array($cname, $page)));
		
		$tVars = array(
			'country' => $country,
			'cid' => $cid,
			'cname' => $cname,
			'rank' => $rank,
			'hl_rank' => $hlrank,
			'page' => $page,
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'country_ranking/for/'.$cid.'/'.$country->urlencodeSEO('country_name').'/page-%PAGE%'),
			'data' => $this->getDataForCountry($country, $ipp, $from),
		);
		return $this->_module->templatePHP('ranking_country.php', $tVars);
	}
	
	private function getDataForCountry(GWF_Country $country, $ipp, $from)
	{
		$cid = $country->getID();
		return GDO::table('GWF_User')->selectObjects('*', "user_countryid=$cid and user_options&0x10000000=0", "user_level DESC ", $ipp, $from);
	}
	
	private function getSinglePageRank($cid, $ipp, $user)
	{
		# Guest or not your country
		if ( ($user === false) || ($user->getCountryID() !== $cid) )
		{
			return array(Common::getGet('page', 1), 1);
		}
		
		# Requested a page, so use it
		if (false !== ($page = Common::getGet('page')))
		{
			return array($page, 1);
		}
		
		# Oh, auto-page detection for the user!
		$rank = WC_RegAt::calcExactCountryRank($user);
		$page = GWF_PageMenu::getPageForPos($rank, $ipp);
		return array($page, $rank);
	}
}

?>