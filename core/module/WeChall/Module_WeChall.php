<?php
require_once 'WC_HTML.php'; # We always need it

# DEBUG
$debug = GWF_DEBUG_EMAIL && GWF_IP6::isLocal();
define('WECHALL_DEBUG_SCORING', $debug); # set true to debug scoring events.
define('WECHALL_DEBUG_LINKING', $debug); # set true to debug site linking
define('WECHALL_CAESUM_PATCH', 'defined');

/**
 * WeChall + GWF! :D
 * @author gizmore
 * @version 1.02
 */
final class Module_WeChall extends GWF_Module
{
	const BOARD_CHALLS = 'Challenges';
	const BOARD_CHALLS_DESCR = 'Ask questions about our challenges here';
	const BOARD_SOLUTIONS = 'Solutions';
	const BOARD_SOLUTIONS_DESCR = 'Discuss solution to our challenges here';
	const BOARD_SITES = 'Sites';
	const BOARD_SITES_DESCR = 'Discuss the Challenge Sites here';
	
	################
	### Instance ###
	################
	private static $instance = false;
	/**
	 * @return Module_WeChall
	 */
	public static function instance() { return self::$instance; }
	
	##############
	### Config ###
	##############
	public function cfgWeChallUser() { return GWF_User::getByIDOrGuest($this->getModuleVar('wc_uid', '0')); }
	public function cfgBasescore() { return $this->getModuleVar('wc_basescore', 10000); }
	public function cfgScorePerChall() { return $this->getModuleVar('wc_score_chall', 125); }
	public function cfgItemsPerPage() { return $this->getModuleVar('wc_ipp', 0); }
	public function cfgChallTags() { return GWF_Settings::getSetting('WC_CHALL_CLOUD', ''); }
	public function cfgMaxSitenameLen() { return $this->getModuleVar('wc_sitename_len', 32); }
	public function cfgJPGraphDir() { return $this->getModuleVar('wc_jpgraph', '/data/tools/code/JPGraph/jpgraph-3.0.7/src/'); }
	public function cfgGraphWidth() { return $this->getModuleVar('wc_graph_w', 640); } 
	public function cfgGraphHeight() { return $this->getModuleVar('wc_graph_h', 480); }
	public function cfgLastPlayersTime() { return $this->getModuleVar('wc_lpt', GWF_Time::ONE_DAY*14); }
//	public function cfgSiteBoardID() { return intval($this->getModuleVar('wc_site_board', 0)); }
//	public function cfgSolutionBoardID() { return intval($this->getModuleVar('wc_sol_board', 0)); }
//	public function cfgChallengeBoardID() { return intval($this->getModuleVar('wc_chall_board', 0)); }
	public function cfgSiteMasterTime() { return $this->getModuleVar('wc_sitemas_dur', GWF_Time::ONE_WEEK);}
	public function cfgLastActiveTime() { return $this->getModuleVar('wc_active_time', GWF_Time::ONE_DAY); }

	public function cfgSiteBoardID() { return GWF_ForumBoard::getByTitle(self::BOARD_SITES)->getID(); }
	public function cfgChallengeBoardID() { return GWF_ForumBoard::getByTitle(self::BOARD_CHALLS)->getID(); }
	public function cfgSolutionBoardID() { return GWF_ForumBoard::getByTitle(self::BOARD_SOLUTIONS)->getID(); }
	##################
	### GWF_Module ###
	##################
//	public function getDependencies() { return array('Forum'=>1.00, 'Votes'=>1.00); } 
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function getDefaultPriority() { return 60; } # 50 is default
	public function getVersion() { return 1.06; }
	public function onInstall($dropTable) { require_once 'GWF_WeChallInstall.php'; return GWF_WeChallInstall::onInstall($this, $dropTable); }
	public function getClasses() { return array('WC_SiteMaster', 'WC_Site', 'WC_Challenge'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/_wc'); }
	public function getDefaultAutoLoad() { return true; }
	public function onCronjob() { require_once 'WC_Cronjob.php'; }
	public function onStartup()
	{
		self::$instance = $this;
//		self::getModule('Forum', true, true);
//		self::getModule('News', true, true);
//		self::getModule('Links', true, true);
//		self::getModule('PM', true, true);
		
		// Register login hook
		GWF_Hook::add(GWF_HOOK::LOGIN_PRE, array(__CLASS__, 'hookLoginPre'));
		GWF_Hook::add(GWF_HOOK::LOGIN_AFTER, array(__CLASS__, 'hookLoginAfter'));
		GWF_Hook::add(GWF_HOOK::VOTED_SCORE, array(__CLASS__, 'hookVoteScore'));
		GWF_Hook::add(GWF_HOOK::ACTIVATE, array(__CLASS__, 'hookRegister'));
		GWF_Hook::add(GWF_HOOK::CHANGE_PASSWD, array(__CLASS__, 'hookChangePass'));
		GWF_Hook::add(GWF_HOOK::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
		GWF_Hook::add(GWF_HOOK::CHANGE_UNAME, array(__CLASS__, 'hookDeleteUser'));
		
		# _ALLWAYS_ include this Oo :(
//		if (false !== ($mv = self::getModule('Votes'))) {
//			$mv->onInclude();
//		}
		$this->onLoadLanguage();
		
		if (Common::getGet('mo')!=='WeChall') {
			$this->onInclude();
		}
		
//		GWF_Website::addDefaultOutput(GWF_HTML::message('Test', sprintf('Your last url is: %s', GWF_Session::getLastURL()), false));

		GWF_Website::setPageTitlePre('[WeChall] ');
		GWF_Website::setMetaTags(WC_HTML::lang('mt_wechall'));
		GWF_Website::setMetaDescr(WC_HTML::lang('md_wechall'));
		GWF_Website::addJavascript('/js/module/WeChall/wc.js?v=5');
		GWF_Website::addJavascriptInline("$(document).ready(function() { wcjsProfileJQuery(); } );");
	}
	
	public static function includeVotes()
	{
		GWF_Module::loadModuleDB('Votes', true);
	}
	public static function includeForums()
	{
		if (false !== GWF_Module::loadModuleDB('Forum', true))
		{
			GWF_ForumBoard::init(true);
		}
	}
	
 	#############
	### Hooks ###
	#############
	/**
	 * Convert Old to New Passwords, by hooking the login.
	 * @param GWF_User $user
	 * @param array $args
	 * @return unknown_type
	 */
	public function hookLoginPre(GWF_User $user, array $args)
	{
		require_once 'WC_PasswordMap.php';
		return WC_PasswordMap::convert($user, $args[0]);
	}
	
	/**
	 * We succesfully logged in and add your last location as link.
	 * @param $user
	 * @param $args
	 * @return unknown_type
	 */
	public function hookLoginAfter(GWF_User $user, array $args)
	{
		# Show last location
		GWF_Website::addDefaultOutput(GWF_Box::box($this->lang('pi_login_link', array(GWF_HTML::display($args[0])))));
		return '';
	}
	
	/**
	 * On Register we link you to wechall.
	 * @param GWF_User $user
	 * @param array $args
	 * @return string error msg 
	 */
	public function hookRegister(GWF_User $user, array $args)
	{
		# Link to WeChall
		if (false === ($site = WC_Site::getWeChall())) {
			return true;
		}
		require_once 'WC_RegAt.php';
		$regat = new WC_RegAt(array(
			'regat_uid' => $user->getID(),
			'regat_sid' => $site->getID(),
			'regat_onsitename' => $user->getVar('user_name'),
			'regat_onsitescore' => 0,
			'regat_challcount' => $site->getVar('site_challcount'),
			'regat_options' => 0,
			'regat_langid' => $site->getLangID(),
			'regat_tagbits' => $site->getTagBits(),
		));
		if (false === ($regat->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $site->increase('site_linkcount', 1)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		require_once 'WC_FirstLink.php';
		if (false === WC_FirstLink::insertFirstLink($user, $site, $user->getVar('user_name'), 0)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return true;
	}
	
	public function hookVoteScore(GWF_User $user, array $args)
	{
		$vsid = (int)$args[0];
		if (false !== ($site = WC_Site::getByVSID($vsid))) {
			return $site->onRecalcVotes();
		}
		elseif (false !== ($chall = WC_Challenge::getByVSID($vsid))) {
			return $chall->onRecalcVotes();
		} else {
			return true;
		}
	}
	
	public function hookChangePass(GWF_User $user, array $args)
	{
		require_once 'WC_PasswordMap.php';
		$uid = $user->getID();
		return GDO::table('WC_PasswordMap')->deleteWhere("pmap_uid=$uid");
	}
	
	public function hookRenameUser(GWF_User $user, array $args)
	{
		list($oldname, $newname) = $args;
		$newname = GDO::escape($newname);
		$uid = $user->getID();
		$sid = WC_Site::getWeChall()->getID();
		return GDO::table('WC_RegAt')->update("regat_onsitename='$newname'", "regat_uid={$uid} AND regat_sid={$sid}");
	}
	
	public function hookDeleteUser(GWF_User $user, array $args)
	{
		# TODO: delete a lot of stuff.
		
		# Let's start with unlinking all sites.
		$userid = $user->getID();
		WC_RegAt::unlinkAll($userid);
	}
	
	#######################
	### Chall Tag Cache ###
	#######################
	/**
	 * Cache Challenge Tag-Cloud, as it is only updated when a new challenge is added. 
	 * @return unknown_type
	 */
	public function cacheChallTags()
	{
		$tags = array();
		$challs = GDO::table('WC_Challenge')->selectObjects();
		
		foreach ($challs as $chall)
		{
			$chall instanceof WC_Challenge;
			
			$t = explode(',', trim($chall->getVar('chall_tags'), ','));
			
			$temp = array();
			
			foreach ($t as $st)
			{
				if ('' === ($st = trim($st))) {
					continue;
				}
				if (!(isset($tags[$st]))) {
					$tags[$st] = 0;
				}
				$tags[$st]++;
				$temp[] = $st;
			}
			
			$chall->saveVar('chall_tags', ','.implode(',', $temp).',');
		}
		
		ksort($tags);
		
		$save = '';
		foreach ($tags as $tag => $count)
		{
			$save .= ':'.$tag.'-'.$count;
		}
		
		return GWF_Settings::setSetting('WC_CHALL_CLOUD', substr($save, 1));

//		return $this->saveModuleVar('wc_ctags', substr($save, 1));
	}
	
	#######################
	### Site Quickjumps ###
	#######################
	private function templateSiteQuickjump($mode)
	{
		$actions = array(
			'detail' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=SiteDetails',
			'ranking' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=SiteRankings',
			'history' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=SiteHistory',
		);
		$tVars = array(
			'sites' => WC_Site::getSites(),
			'mode' => $mode,
			'form_action' => $actions[$mode],
		);
		return $this->templatePHP('site_quickjump.php', $tVars);
	}
	public function templateSiteQuickjumpDetail()
	{
		return $this->templateSiteQuickjump('detail');
	}
	public function templateSiteQuickjumpRanking()
	{
		return $this->templateSiteQuickjump('ranking');
	}
	public function templateSiteQuickjumpHistory()
	{
		return $this->templateSiteQuickjump('history');
	}
	
	##################
	### Guestbooks ###
	##################
	public static function hrefCreateGB()
	{
		return GWF_WEB_ROOT.'index.php?mo=WeChall&me=CreateGB';
	}
	
	############
	### News ###
	############
	public function showBirthdayNews()
	{
//		var_dump('HERE');
		# Logged in?
		if (false === ($user = GWF_Session::getUser())) {
//			echo '<div>Not logged in!</div>';
			return '';
		}
		
		# Don't want birthdays?
		if (!$user->isOptionEnabled(GWF_User::SHOW_OTHER_BIRTHDAYS)) {
//			echo '<div>DO NOT WANT BD!</div>';
			return '';
		}
		
		# Marked Read?
		$userdata = $user->getUserData();
		$bdm = isset($userdata['birthdaymark']) ? $userdata['birthdaymark'] : '00';
		if ($bdm === sprintf('%02d', date('W')))
		{
//			echo '<div>THIS WEEK IS MARKED READ!</div>';
			return '';
		}
		
		return $this->showBirthdays($user);
	}
	
	private function showBirthdays(GWF_User $user)
	{
		# Prepare dates (starts at monday)
		$userdate = array();
		$time = $timet = GWF_Time::getTimeWeekStart();
		$dates = array();
		for ($i = 0; $i < 7; $i++)
		{
			$date = date('md', $timet);
			$dates[] = $date;
			$userdate[$date] = array();
			$timet += GWF_Time::ONE_DAY;
		}
		$monday = $dates[0];
		$sunday = $dates[6];
		
		
		$showbd = GWF_User::SHOW_BIRTHDAY;
		$users = GWF_TABLE_PREFIX.'user';
		$query = "SELECT user_name, user_birthdate, SUBSTR(user_birthdate, 5) AS bd FROM $users WHERE user_options&$showbd AND SUBSTR(user_birthdate, 5) BETWEEN $monday AND $sunday";
		$db = gdo_db();
		if (false === ($result = $db->queryRead($query))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return '';
		}
		
		# No Birthdays
		if (0 === $db->numRows($result)) {
			return '';
		}
		
		# Group
		while (false !== ($row = $db->fetchRow($result)))
		{
			$name = $row[0];
			$fulldate = $row[1];
			$date = $row[2];
			$userdate[$date][] = $name;
		}
		$db->free($result); # DB done
		
		return $this->displayBirthdays($userdate);
	}
	
	private function displayBirthdays(array $userdate)
	{
		# more vars
		$today = date('md');
		$tommorow = date('md', time() + GWF_Time::ONE_DAY);
		$yesterday = date('md', time() - GWF_Time::ONE_DAY);
		
		# Output
		$href = '/index.php?mo=WeChall&me=BirthdayRead';
		$title = $this->lang('bdnews_title');
		$text = $this->lang('bdnews_body_init', array($href));
		$weekdays = GWF_Time::getWeekdaysFromMo();
		$i = -1;
		foreach ($userdate as $date => $data)
		{
			$i++;
			if (count($data) === 0) {
				continue;
			}
			
			$day = $weekdays[$i];
			if ($date === $yesterday) {
				$day = WC_HTML::lang('Yesterday');
			}
			elseif ($date === $today) {
				$day = '[b]'.WC_HTML::lang('Today').'[/b]';
			}
			elseif ($date === $tommorow) {
				$day = WC_HTML::lang('Tommorow');
			}
			elseif ($date < $today) {
				$day = WC_HTML::lang('bd_over', array($day));
			}
			elseif ($date > $today) {
				$day = WC_HTML::lang('bd_soon', array($day));
			}
			
			$text .= $day.': ';
			$app = '';
			foreach ($data as $username)
			{
				$app .= sprintf(', [url=/profile/%s]%s[/url]', urlencode($username), htmlspecialchars($username));
//				$text .= $day.': '.implode(', ', $data).PHP_EOL;
			}
			$text .= substr($app, 2).PHP_EOL;
//			$text .= $day.': '.implode(', ', $data).PHP_EOL;
		}
		
		$wechalluser = Module_WeChall::instance()->cfgWeChallUser();
		$english = GWF_Language::getEnglish();
		$news = GWF_News::newNews(GWF_Time::getDate(GWF_Date::LEN_SECOND), 0 , $wechalluser->getID(), $english->getID(), $title, $text, true);
		
		return Module_News::displayItem($news);
	}
	
	public function showChallengeNews()
	{
		# Logged in?
		if (false === ($user = GWF_Session::getUser())) {
			return '';
		}
		$userid = $user->getID();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = "SELECT site_name, regat_challcount, site_challcount, site_url FROM $regat JOIN $sites ON site_id=regat_sid WHERE regat_challcount != site_challcount AND regat_uid=$userid";
		$db = gdo_db();
		if (false === ($result = $db->queryRead($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($db->numRows($result) === 0) {
			$db->free($result);
			return '';
		}
		
		$href = '/index.php?mo=WeChall&me=ChallNewsRead';
		$title = $this->lang('cnews_title');
		$text = $this->lang('cnews_body', array($href)).PHP_EOL.PHP_EOL;
		while (false !== ($row = $db->fetchRow($result)))
		{
			$mark = intval($row[1]);
			$total = intval($row[2]);
			$anchor = sprintf('[url=%s]%s[/url]', htmlspecialchars($row[3]), htmlspecialchars($row[0]));
			$text .= $this->lang('cnews_item', array($total-$mark, $anchor, $total)).PHP_EOL;
		}

		$db->free($result);
		
		if (false === ($thm = Module_WeChall::instance()->cfgWeChallUser())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$english = GWF_Language::getEnglish();
		
		$news = GWF_News::newNews(GWF_Time::getDate(GWF_Date::LEN_SECOND), 0 , $thm->getID(), $english->getID(), $title, $text, true);
		
		return Module_News::displayItem($news);
	}
	
	public function showSiteMasterNews()
	{
		$masters = WC_SiteMaster::getMasters($this->cfgSiteMasterTime());
		
		if (count($masters) === 0) {
			return '';
		}
		
		$title = $this->lang('mnews_title');
		$text = $this->lang('mnews_body', array(GWF_WEB_ROOT.'site_masters')).PHP_EOL.PHP_EOL;
		foreach ($masters as $row)
		{
			$row instanceof WC_SiteMaster;
			$site = $row->getSite();
			$text .= $this->lang('mnews_item', array($row->getUser()->displayUsername(), $site->getURL(), $site->getVar('site_name'), $row->displayTrackTime(), $row->displayStartPerc())).PHP_EOL;
		}
		
		if (false === ($wcu = $this->cfgWeChallUser())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$english = GWF_Language::getEnglish();
		
		$news = GWF_News::newNews(GWF_Time::getDate(GWF_Date::LEN_SECOND), 0 , $wcu->getID(), $english->getID(), $title, $text, true);
		
		return Module_News::displayItem($news);
	}
	
//	public function countMasterNews()
//	{
//		return WC_SiteMaster::countMasters($this->cfgSiteMasterTime()) > 0 ? 1 : 0;
//	}
	
	
	public function getNewsCount()
	{
		$count = 0;

		# Masters
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteMaster.php';
		$mastercount = WC_SiteMaster::countMasters($this->cfgSiteMasterTime());
		if ($mastercount > 0) {
//			$count++;
		}
		
		# Account Links()
		$count += $this->getNewsCountLinking();
		
		# Logged in?
		if (false === ($user = GWF_Session::getUser())) {
			return 0;
		}
		$db = gdo_db();
		$userid = $user->getID();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		
		# Count Chall News
		$query = "SELECT 1 FROM $regat JOIN $sites ON site_id=regat_sid WHERE regat_challcount != site_challcount AND regat_uid=$userid";
		if (false === ($result = $db->queryFirst($query, false))) {
			$count += 0;
		} else {
			$count += 1;
		}
		
		# Count BDay News
		if ($user->isOptionEnabled(GWF_User::SHOW_OTHER_BIRTHDAYS))
		{
			$userdata = $user->getUserData();
			$bdm = isset($userdata['birthdaymark']) ? $userdata['birthdaymark'] : '00';
			if ($bdm !== sprintf('%02d', date('W')))
			{
				$count += $this->getNewsCountBDay();
			}
			
		}
		
		# Regular News
		$count += $this->getRegularNewsCount();
		
		return $count;
	}
	
	private function getRegularNewsCount()
	{
		return 0;
	}
	
	private function getNewsCountBDay()
	{
		$db = gdo_db();
		$users = GWF_TABLE_PREFIX.'user';
		$showbd = GWF_User::SHOW_BIRTHDAY;
		
		$time = $timet = GWF_Time::getTimeWeekStart();
		$dates = array();
		for ($i = 0; $i < 7; $i++)
		{
			$dates[] = date('md', $timet);
			$timet += GWF_Time::ONE_DAY;
		}
		$monday = $dates[0];
		$sunday = $dates[6];
		
		$query = "SELECT 1 FROM $users WHERE user_options&$showbd AND SUBSTR(user_birthdate, 5) BETWEEN $monday AND $sunday";
		if (false === ($result = $db->queryFirst($query, false))) {
			return 0;
		}
		return 1;
	}
	
	private function getNewsLinkingCondition()
	{
		$today = GWF_Time::getDate(GWF_Date::LEN_DAY);
		return "fili_date='$today' AND fili_percent>0";
	}
	
	private function getNewsCountLinking()
	{
		return 0;
//		$db = gdo_db();
//		$first_link = GWF_TABLE_PREFIX.'wc_first_link';
//		$condition = $this->getNewsLinkingCondition();
//		if (false === ($result = $db->queryFirst("SELECT 1 FROM $first_link WHERE $condition", false))) {
//			return 0;
//		}
//		return (int)$result[0];
	}
	
	private function getFirstLinkNews()
	{
		$db = gdo_db();
		$first_link = GWF_TABLE_PREFIX.'wc_first_link';
		$condition = $this->getNewsLinkingCondition();
		$query = "SELECT * FROM $first_link WHERE $condition";
		return $db->queryAll($query);
	}
	
	public function showAccountLinkNews()
	{
//		$db = gdo_db();
//		$users = GWF_TABLE_PREFIX.'user';
////		$history = GWF_TABLE_PREFIX.'wc_user_history';
//		$regat = GWF_TABLE_PREFIX.'wc_regat';
//		$sites = GWF_TABLE_PREFIX.'wc_site';
////		$time = GWF_Time::getTimeWeekStart();
//		$today = GWF_Time::getDate(GWF_Date::LEN_DAY);
//		$query = 
//			"SELECT user_name, site_name, regat_solved ".
//			"FROM $regat ".
//			"LEFT JOIN $users ON user_id=regat_uid ".
//			"LEFT JOIN $sites ON site_id=regat_sid ".
//			"WHERE regat_linkdate='$today' AND regat_solved>0";
//		if (false === ($result = $db->queryAll($query))) {
//			return '';
//		}
		
		$result = $this->getFirstLinkNews();
		if (count($result) === 0) {
			return '';
		}
		
		$msg = '';
		foreach ($result as $row)
		{
			$un = $row['fili_username'];
			$sn = $row['fili_sitename'];
//			$site_link = sprintf('[url=%s]%s[/url]', GWF_WEB_ROOT, urlencode($sn), GWF_HTML::display($sn));
			$site_link = sprintf('[b]%s[/b]', ($sn));
			$perc = sprintf('%.02f', $row['fili_percent']);
			$profile_link = sprintf('[url=/profile/%s]%s[/url]', $un, $un);
			$msg .= $this->lang('newsrow_link', array($profile_link, $site_link, $perc)).PHP_EOL;
//			$msg .= sprintf('%s', $this->lang('newsrow_link', sprintf('<a href="%sprofile/%s">%s</a>', GWF_WEB_ROOT, urlencode($un), GWF_HTML::display($row['fili_username'])), , )).PHP_EOL;
		}
		
		$title = $this->lang('newsrow_linkt');
		
		$wechalluser = $this->cfgWeChallUser();
		$english = GWF_Language::getEnglish();
		
		$news = GWF_News::newNews(GWF_Time::getDate(GWF_Date::LEN_SECOND), 0 , $wechalluser->getID(), $english->getID(), $title, $msg, true);
		
		return Module_News::displayItem($news);
		
	}
	
	#############
	### HREFs ###
	#############
	public function hrefDDOS($siteid)
	{
		return $this->getMethodURL('SiteDDOS', "&siteid=$siteid");
	}
	
	#########################
	### For Zipping Stuff ###
	#########################
	public function getExtraDirs()
	{
		return array('form');
	}
	
	public function getExtraFiles()
	{
		return array('chall_check_solution.php', 'html_head.php', 'html_foot.php', 'remoteupdate.php');
	}
	
	###########################
	### User Icons in Forum ###
	###########################
	public static function displayIcons(GWF_User $user)
	{
		$back = '';
		$db = gdo_db();
		$uid = $user->getVar('user_id');
		$regats = GWF_TABLE_PREFIX.'wc_regat';
		$query = "SELECT regat_sid, regat_solved FROM $regats WHERE regat_uid=$uid";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}
		$i = 0;
		while (false !== ($row = $db->fetchRow($result)))
		{
			if (0.05 > ($solved = floatval($row[1]))) {
				continue;
			}
			if ((++$i % 5) === 0) {
				$back .= '<br/>'.PHP_EOL;
			}
			$siteid = (int) $row[0];
			$site = WC_Site::getByID($siteid);
			$back .= $site->displayLogoUN($user->getVar('user_name'), $solved, 6, 28, true).PHP_EOL;
		}
		
		$db->free($result);
		
		return $back;
	}
	
	public function isExcludedFromAPI(GWF_User $user, $override_pass=false)
	{
		$data = $user->getUserData();
		if (!isset($data['WC_NO_XSS'])) {
			return false;
		}
		
		if ( (isset($data['WC_NO_XSS_PASS'])) && ($override_pass === $data['WC_NO_XSS_PASS']) ) {
			return false;
		}
		
		return sprintf('The user %s does not want to be included in API calls.', $user->displayUsername());
	}
	
	public function isAPIKeyCorrect(GWF_User $user, $api_key)
	{
		$data = $user->getUserData();
		if (!isset($data['WC_NO_XSS_PASS'])) {
			return false;
		}
		return $data['WC_NO_XSS_PASS'] === $api_key;
	}
}

?>