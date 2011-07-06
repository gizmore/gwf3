<?php

/**
 * Install WeChall modulevars and create some paths.
 * Also Adjust some counters.
 * @author gizmore
 * @version 1.0
 */
final class GWF_WeChallInstall
{
	private static $more_classes = array('WC_API_Block', 'WC_Challenge', 'WC_ChallSolved', 'WC_Freeze', 'WC_HistorySite', 'WC_HistoryUser2', 'WC_MathChall', 'WC_PasswordMap', 'WC_SiteAdmin', 'WC_SiteDescr', 'WC_Site', 'WC_RegAt', 'WC_SiteMaster', 'WC_SiteCats', 'WC_SiteFavorites', 'WC_FirstLink', 'WC_SolutionBlock', 'WC_FavCats');
	
	public static function onInstall(Module_WeChall $module, $dropTable)
	{
		Module_WeChall::includeForums();
		return
		self::installMoreClasses($module, $dropTable).
		GWF_ModuleLoader::installVars($module, array(
			'wc_uid' => array('0', 'script'),
			'wc_basescore' => array('1000', 'int', '1'),
			'wc_score_chall' => array('25', 'int', '0', '1000'),
			'wc_ipp' => array('50', 'int', '1', '255'),
//			'wc_ctags' => array('', 'script'),
			'wc_sitename_len' => array('32', 'int', '1', '63'),
			'wc_jpgraph' => array('/data/tools/code/JPGraph/jpgraph-3.0.7/src/', 'text', '0', '255'),
			'wc_graph_w' => array('640', 'int', '1', '4096'),
			'wc_graph_h' => array('480', 'int', '1', '2048'),
			'wc_lpt' => array(GWF_Time::ONE_DAY*14, 'time', '0', GWF_Time::ONE_YEAR),
			'wc_sol_board' => array('0', 'script'),
			'wc_site_board' => array('0', 'script'),
			'wc_chall_board' => array('0', 'script'),
			'wc_sitemas_dur' => array('1 week', 'time', GWF_Time::ONE_DAY, GWF_Time::ONE_MONTH),
			'wc_active_time' => array('1 day', 'time', 0, GWF_Time::ONE_WEEK),
		)).
		self::createForums($module, $dropTable).
		self::createDBIMGDIR($module, $dropTable).
		self::recalcVotes($module, $dropTable).
		self::fixSiteLinkCount($module, $dropTable).
		self::fixChallTags($module).
		self::fixWeChallUser($module).
		self::installSiteWeChall($module).
		self::installSiteColors($module);
	}
	
	private static function createForums(Module_WeChall $module, $dropTable)
	{
		$back = '';
//		if (false === ($module_forum = GWF_Module::getModule('Forum'))) {
//			return GWF_HTML::err('ERR_MODULE_MISSING', 'Forum');
//		}
//		$module_forum->onInclude();
		
		$boards = GDO::table('GWF_ForumBoard');
		
		$t = $boards->escape(Module_WeChall::BOARD_CHALLS);
		if (false === ($board = $boards->getBy('board_title', $t))) {
			if (false === ($board = GWF_ForumBoard::createBoard(Module_WeChall::BOARD_CHALLS, Module_WeChall::BOARD_CHALLS_DESCR, 1, GWF_ForumBoard::GUEST_VIEW|GWF_ForumBoard::ALLOW_THREADS, 0))) {
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		$boardid = $board === false ? 0 : $board->getID();
		$module->saveModuleVar('wc_chall_board', $boardid);
		
		$t = $boards->escape(Module_WeChall::BOARD_SOLUTIONS);
		if (false === ($board = $boards->getBy('board_title', $t))) {
			if (false === ($board = GWF_ForumBoard::createBoard(Module_WeChall::BOARD_SOLUTIONS, Module_WeChall::BOARD_SOLUTIONS_DESCR, 1, GWF_ForumBoard::GUEST_VIEW|GWF_ForumBoard::ALLOW_THREADS, 0))) {
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		$boardid = $board === false ? 0 : $board->getID();
		$module->saveModuleVar('wc_sol_board', $boardid);
		
		$t = $boards->escape(Module_WeChall::BOARD_SITES);
		if (false === ($board = $boards->getBy('board_title', $t))) {
			if (false === ($board = GWF_ForumBoard::createBoard(Module_WeChall::BOARD_SITES, Module_WeChall::BOARD_SITES_DESCR, 1, GWF_ForumBoard::GUEST_VIEW|GWF_ForumBoard::ALLOW_THREADS, 0))) {
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		$boardid = $board === false ? 0 : $board->getID();
		$module->saveModuleVar('wc_site_board', $boardid);

		return $back;
	}

	private static function createDBIMGDIR(Module_WeChall $module, $dropTable)
	{
		$paths = array('dbimg/logo', 'dbimg/logo_gif');
		foreach ($paths as $path)
		{
			if (is_dir($path) && is_writable($path)) {
				continue;
			}			
			if (false === mkdir($path, GWF_CHMOD)) {
				return GWF_HTML::err('ERR_WRITE_FILE', array($path));
			}
			chmod($path, GWF_CHMOD);
		}
		return '';
	}

	private static function recalcVotes(Module_WeChall $module, $dropTable)
	{
		if (false === ($mod_votes = GWF_Module::loadModuleDB('Votes', true))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Votes'));
		}
		
		if (false === WC_Site::onRecalcAllVotes()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === WC_Challenge::onRecalcAllVotes()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}

	private static function fixSiteLinkCount(Module_WeChall $module, $dropTable)
	{
		if (false === WC_Site::fixAllLinkCounts()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}
	
	private static function fixChallTags(Module_WeChall $module)
	{
		$module->cacheChallTags();
		return '';
	}
	
	private static function fixWeChallUser(Module_WeChall $module)
	{
		if (false === ($user = GWF_User::getByName('WeChall'))) {
			$user = new GWF_User(array(
				'user_name' => 'WeChall',
				'user_email' => 'wechall@wechall.net',
				'user_password' => GWF_Password::hashPasswordS('wechallbot'),
				'user_regdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
				'user_regip' => GWF_IP6::getIP(GWF_IP_EXACT, '127.0.0.1'),
				'user_lastactivity' => time(),
				'user_options' => GWF_User::BOT,
			));
			if (false === $user->insert()) {
				echo GWF_HTML::error('WeChall Install', 'Can not find user WeChall');
				$uid = 0;
			} else {
				$uid = $user->getID();
			}
		} else {
			$uid = $user->getID();
		}
		
		if (false === $module->saveModuleVar('wc_uid', $uid)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}
	
	private static function installMoreClasses(Module_WeChall $module, $dropTable)
	{
		foreach (self::$more_classes as $classname)
		{
			require_once 'core/module/WeChall/'.$classname.'.php';
		}
		return GWF_ModuleLoader::installModuleClassesB($module, self::$more_classes, $dropTable);
	}
	
	private static function installSiteWeChall(Module_WeChall $module)
	{
		if (false !== ($site = WC_Site::getByName('WeChall'))) {
			return '';
		}
		
		$options = WC_Site::AUTO_UPDATE;
		
		$site = new WC_Site(array(
			'site_id' => 1,
			'site_status' => WC_Site::UP,
			'site_name' => 'WeChall',
			'site_classname' => 'WC',
//			'site_description' => 'WeChall sucks ass',
			'site_logo_v' => 0,
			'site_country' => 0,
			'site_language' => GWF_Language::getEnglish()->getID(),
			'site_joindate' => '20080218000000',
			'site_launchdate' => '20080218',
			'site_authkey' => 'iusdgsdgsiog3!s',
			'site_xauthkey' => 'rw98t693g!9sg',
			'site_irc' => 'irc://irc.idlemonkeys.net#wechall',
			'site_url' => 'http://'.GWF_DOMAIN.GWF_WEB_ROOT,
			'site_url_mail' => 'index.php?mo=WeChall&me=CrossSite&link=%USERNAME%&email=%EMAIL%&no_session=yes',
			'site_url_score' => 'index.php?mo=WeChall&me=CrossSite&score=%USERNAME%&no_session=yes',
			'site_url_profile' => 'profile/%USERNAME%',
			'site_score' => 0, # calced score
			'site_basescore' => 10000,
			'site_avg' => 0.0,
			'site_dif' => 3.0,
			'site_fun' => 3.0,
			'site_vote_dif' => 0,
			'site_vote_fun' => 0,
			'site_maxscore' => 0,
			'site_challcount' => 0,
			'site_usercount' => 0,
			'site_linkcount' => 0,
			'site_visit_in' => 0,
			'site_visit_out' => 0,
			'site_options' => $options,
			'site_tags' => 'Exploit,Programming,Stegano,Crypto',
			'site_boardid' => 0,
			'site_threadid' => 0,
			'site_tagbits' => 0,
			'site_color' => '0000FF',
		));
		if (false === ($site->onCreateSite($module, $back))) {
			return $back;
		}
		
		require_once 'core/module/WeChall/WC_SiteDescr.php';
		if (false === WC_SiteDescr::insertDescr($site->getID(), 1, 'Please edit me :)')) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return '';
	}
	
	private static function installSiteColors(Module_WeChall $module)
	{
		$classnames = array(
			'WC' => 'c6d0da',
			'HQ' => '00ffff',
			'Rankk' => 'a50000',
			'TBS' => 'f8b128',
			'Elec' => 'ffff00',
			'Asp' => 'cdcdcd',
			'HS' => '48633b',
			'NC' => '5d5d5d',
			'DYM' => 'fec752',
			'Lost' => 'bbbbbb', # or 000000
			'Yash' => 'aaaaaa',
			'Mirmo' => '232323',
			'BQ' => 'dbdbdc',
			'NF' => '93836e',
			'Hispa' => '8ddc42',
			'HTS' => '409fff', # or 161616
			'TIL' => '688ade',
			'ElH' => 'e2e9ee',
			'TT1' => '2370aa',
			'TDH' => 'ffec62',
			'MiB' => '42d153',
			'Ma' => '008000',
			'PHM' => '000000', #
			'BBox' => '', # DOWN (green)
			'Euler' => 'c7e1f8',
			'0ID' => 'ed8c0f',
			'HDE' => '', # hackits.de down (green)
			'Hax' => '00b000',
			'HBH' => 'bec8c5',
			'Hacker' => 'd0f4df',
			'Bl0' => '', # down
			'SA' => '11141d',
			'osix' => '2e506b',
			'RCode' => 'f60101',
			'CSTC' => '8883b8',
			'LB' => '4d8ac7',
			'Asta' => '000000', # eeeeee
			'WoW' => 'ffffff',
			'THC' => '804b69',
			'HBBS' => 'd0d0d0',
			'CLIB' => 'ffffff',
			'ST' => '202020',
			'Root' => '000000',
			'SPOJ' => '07077e'
		);
		foreach ($classnames as $classname => $color)
		{
			if ($color !== '')
			{
				if (false !== ($site = WC_Site::getByClassName($classname)))
				{
					$site->saveVar('site_color', $color);			
				}
			}
		}
	}
}

?>