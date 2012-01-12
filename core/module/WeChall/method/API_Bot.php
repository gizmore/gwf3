<?php
/**
 * Pipsqueek bot interaction.
 * @author gizmore
 */
final class WeChall_API_Bot extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteCond %{QUERY_STRING} username=([^&]+)'.PHP_EOL.
			'RewriteRule ^wechall.php$ index.php?mo=WeChall&me=API_Bot&username=%1&no_session=true&ajax=true'.PHP_EOL.
			'RewriteCond %{QUERY_STRING} username=([^&]+)'.PHP_EOL.
			'RewriteRule ^wechallchalls.php$ index.php?mo=WeChall&me=API_Bot&username=%1&wechall=yes&no_session=true&ajax=true'.PHP_EOL;
//			'RewriteCond %{QUERY_STRING} sitename=([^&]+)'.PHP_EOL.
//			'RewriteRule ^wechallonsite.php$ index.php?mo=WeChall&me=Bot&onsite=%1&no_session=true'.PHP_EOL	;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::plaintext();
		
		$input = trim(Common::getGetString('username', ''));
		
		if (false !== ($onsitename = Common::getGet('onsitename')) && false !== ($sitename = Common::getGet('sitename'))) {
			die($this->rawOnSiteStats($this->_module, $sitename, $onsitename));
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		
		if (Common::getGet('wechall') === 'yes') {
			die($this->wechallChalls($this->_module, $input));
		}
		
		if ($input === '') {
			$message = sprintf('Try %s?username=name/rank. New: ?username=!sitename username/rank. Or: ?username=!sites usernname', 'wechall.php');
			die($message);
		}
		
		if (strpos($input, '!sites') === 0) {
			$this->showSites($this->_module, $input);
		}
		elseif (strpos($input, '!site') === 0) {
			$this->showSiteDetail($this->_module, $input);
		}
		elseif (strpos($input, '!') === 0) {
			$this->showSite($this->_module, $input);
		}
		else {
			die($this->showGlobal($this->_module, $input));
		}
	}
	
	public function showGlobal(Module_WeChall $module, $input)
	{
		if (false !== ($user = GWF_User::getByName($input))) {
			$rank = WC_RegAt::calcExactRank($user);
		}
		elseif (false !== ($user = WC_RegAt::getUserByGlobalRank($input))) {
			$rank = (int) $input;
		}
		else {
			$message = sprintf('The user does not exist on https://www.wechall.net');
			die($message);
		}
		
//		if (false !== ($error = $this->_module->isExcludedFromAPI($user))) {
//			die($error);
//		}
		
		$userid = $user->getID();
		$username = $user->displayUsername();
		$score = $user->getVar('user_level');
		$usercount = GDO::table('GWF_User')->countRows();
		$average = GDO::table('WC_Regat')->selectVar('AVG(regat_solved)', 'regat_uid='.$userid);
//		$average = GDO::table('WC_Regat')->selectAverage('regat_solved', "regat_uid=$userid");
		$nSites = GDO::table('WC_Regat')->countRows('regat_uid='.$userid);
		
		# Build rankup text.
		if ($rank > 1) {
			$user2 = WC_RegAt::getUserByGlobalRank($rank-1);
			$pointsNeeded = $user2->getVar('user_level') - $score + 1;
			$rankuptxt = $username.' needs '.$pointsNeeded.' points to rankup.';  
		} else {
			$rankuptxt = 'Praise the Grand-Master.';
		}
		
		$infotxt = sprintf("$username is ranked $rank from $usercount, linked to $nSites sites with an average of %.02f%% solved. $username has a totalscore of $score. $rankuptxt", $average*100);
		return $infotxt;
	}
	
	private function showUsageSites()
	{
		$sites = GDO::table('WC_Site')->selectColumn('site_classname', "site_status='up'", 'site_classname ASC');
		return 'Sites: '.implode(', ', $sites).'.';
	}
	
	private function showSites(Module_WeChall $module, $input)
	{
		$input = substr($input, 1);
		$sitename = trim(Common::substrUntil($input, ' '));
		$username = trim(Common::substrFrom($input, ' ', ''));
	
		if ($username === '') {
			die($this->showUsageSites());
		}
		
		if (false !== ($user = GWF_User::getByName($username))) {
			$rank = WC_RegAt::calcExactRank($user);
		}
		
		elseif (false !== ($user = WC_RegAt::getUserByGlobalRank($username))) {
			$rank = (int) $username;
		}

		else {
			die( "The user doesnt exist at https://www.wechall.net" );
		}
		
//		if (false !== ($error = $this->_module->isExcludedFromAPI($user))) {
//			die($error);
//		}
		
		$username = $user->displayUsername();
		$regats = WC_RegAt::getRegats($user->getID(), 'regat_solved DESC');
		$sitedata = array();
		$keepthrough = 5;
		foreach ($regats as $row)
		{
			$perc = $row->getVar('regat_solved') * 100;
			if ($perc < 10 && $keepthrough < 0) {
				continue;
			}
			$keepthrough--;
			$sitedata[] = sprintf('%s(%.02f%%)', $this->getClassnameFromID($row->getVar('regat_sid')), $perc);
		}
		$count = count($sitedata);
		$sitedata = implode(', ', $sitedata);
		$out = sprintf('%s plays %d sites, primary: %s.', $username, count($regats), $sitedata);
		die($out);
	}

	private function getClassnameFromID($sid)
	{
		static $sites = array();
		
		$sid = (int)$sid;
		if (!isset($sites[$sid])) {
			$sites[$sid] = WC_Site::getByID($sid);
		}
		
		if ($sites[$sid] === false) {
			return 'Unknown SiteID: '.$sid;
		}
		return $sites[$sid]->getVar('site_classname');
	}
	
	private function showSite(Module_WeChall $module, $input)
	{
		$sitename = Common::substrUntil(substr($input,1), ' ');
		$username = Common::substrFrom($input, ' ');

		if (false !== ($site = WC_Site::getByName($sitename))) {
		}
		elseif (false !== ($site = WC_Site::getByClassName($sitename))) {
		}
		else {
			die($this->showUsageSites());
		}
		
		$siteid = $site->getID();
		
		if (false !== ($user = GWF_User::getByName($username))) {
			$rank = WC_RegAt::calcExactSiteRank($user, $siteid);
		}
		elseif (false !== ($user = WC_RegAt::getUserBySiteRank($siteid, $username))) {
			$rank = (int) $username;
		}
		else {
			die('User Not Found on https://www.wechall.net');
		}
		
//		if (false !== ($error = $this->_module->isExcludedFromAPI($user))) {
//			die($error);
//		}
		
		
		$sitename = $site->getVar('site_name');
		$siteurl = $site->getURL();
		$userid = $user->getID();
		$username = $user->getVar('user_name');

		if (false === ($regat = WC_RegAt::getRegatRow($userid, $siteid)))
		{
			die(sprintf('The User %s is not linked to %s at %s', $username, $sitename, $siteurl));
		}
	
		$onsitescore = $regat->getOnsiteScore();
		$onsiterank = $regat->getOnsiteRank();
		$maxonsitescore = $site->getOnsiteScore();
		$percent = $regat->getVar('regat_solved') * 100;
		$points = $regat->getVar('regat_score');# $site->calcScore($regat);
		
		if ($onsiterank < 1)
		{
			$out = sprintf(
				'%s completed %%%.02f on %s (%d of %d points). '.
				'On %s , %s\'s rank is unknown. '.
				'Linked to WeChall he claims rank %s, scoring %d points.',
	//			'Within WeChall, %s is at rank %d on %s scoring %d points',
				$username, $percent, $sitename, $onsitescore, $maxonsitescore,
				$siteurl, $username,
				$rank, $points 
			);
		}
		else
		{
			$out = sprintf(
				'%s completed %%%.02f on %s (%d of %d points). '.
				'On %s %s is at rank %s. '.
				'Linked to WeChall he claims rank %s, scoring %d points.',
	//			'Within WeChall, %s is at rank %d on %s scoring %d points',
				$username, $percent, $sitename, $onsitescore, $maxonsitescore,
				$siteurl, $username, $onsiterank,
				$rank, $points 
			);
		}
		
		
		die($out);
		
	}
	
	/**
	 * Wechall internally bot response.
	 * The advantage over the other method is accurate challcount.
	 * @param Module_WeChall $module
	 * @param string $input
	 * @return string
	 */
	public function wechallChalls(Module_WeChall $module, $input)
	{
		if ($input === '') {
			return sprintf('Try wechallchalls.php?userame=blub');
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		
		$wechall = WC_Site::getWeChall();
		$siteid = $wechall->getID();

		if (false !== ($user = GWF_User::getByName($input))) {
			$rank = WC_RegAt::calcExactSiteRank($user, $siteid);
		}
		elseif (false !== ($user = WC_RegAt::getUserBySiteRank($siteid, $input))) {
			$rank = intval($input);
		}
		else {
			return sprintf('The user does not exist.');
		}
		
//		if (false !== ($error = $this->_module->isExcludedFromAPI($user))) {
//			return $error;
//		}

		$userid = $user->getID();
		$username = $user->displayUsername();
		$solvedCount = WC_ChallSolved::getSolvedCount($userid);
		$score = WC_Challenge::getScoreForUser($user);
		$challcount = WC_Challenge::getChallCount();
		$maxScore = WC_Challenge::getMaxScore();
		$percent = $score / $maxScore * 100;
		
		$out = sprintf(
			'%s solved %d of %d Challenges with %d of %d possible points (%.02f%%).',
			$username, $solvedCount, $challcount, $score, $maxScore, $percent
		);

		if ($rank !== false) {
			$out .= sprintf(' Rank for the site WeChall: %d', $rank);
		}
		
		return $out;
	}
	
	private function rawOnSiteStats(Module_WeChall $module, $sitename, $onsitename)
	{
		if ( (false === ($site = WC_Site::getByName($sitename))) && (false === ($site = WC_Site::getByClassName($sitename))) ) {
			return $this->_module->lang('err_site');
		}
		
		$site = $site->getSiteClass();
		$site instanceof WC_Site;
		$url = $site->getScoreURL($onsitename);
		if (false === ($result = $site->parseStats($url))) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}

		$rank = (int)$result[1];
		$score = (int)$result[0];
		
		$maxscore = $site->getOnsiteScore();
		$percent = $score/$maxscore*100;
		
		$msg_rank = $rank > 0 ? ' and claims rank '.$rank : '';
		
		$msg = sprintf('On %s , the user %s scores %d of %d points(%.02f%%)%s.', $site->getURL(), $onsitename, $score, $maxscore, $percent, $msg_rank);
		
		return $msg;
	}
	
	private function showSiteDetail($module, $input)
	{
		$classname = trim(Common::substrFrom($input, ' ', ''));
		if (false === ($site = WC_Site::getByClassName($classname))) {
			die('Unknown Site '.$classname);
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteDescr.php';
		$descr = WC_SiteDescr::getDescription($site->getID());
//		$descr = $site->getVar('site_description');
//		$message = $descr;
		$message = Common::stripMessage($descr, 148);
		die(sprintf('%s (%s challs): %s - %s', $site->displayName(), $site->getChallcount(), $site->getVar('site_url'), $message));
	}
}
?>
