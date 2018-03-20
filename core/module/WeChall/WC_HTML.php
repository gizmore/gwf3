<?php
##################################
### --- WRAP OLD FUNCTIONS --- ###
##################################
function html_head($title="WeChall", $withSidebar=false, $strict=true, $scripts=array(), $xhtml=true, $css=array())
{
	GWF_Website::setPageTitle($title);
	WC_HTML::$LEFT_PANEL = $withSidebar;
	WC_HTML::$RIGHT_PANEL = $withSidebar;
	foreach ($css as $path)
	{
		GWF_Website::addCSS($path);
	}
}
function htmlDisplayError($msg, $log=true) { echo GWF_HTML::error('WeChall', $msg, $log); return false; }
function htmlDisplayMessage($msg, $log=true) { echo GWF_HTML::message('WeChall', $msg, $log); return true; }
function htmlSendToLogin() { echo GWF_HTML::err('ERR_LOGIN_REQUIRED'); /* GWF_Website::redirect(GWF_WEB_ROOT.'login'); */ }
function htmlTitleBox($title, $subtext) { echo GWF_Box::box($subtext, $title); }
# END OF WRAPPER #

### ----------------------------------------------------------------- ###
/**
 * WeChall specific HTML.
 * Mostly Convinient collections of html output.
 * @author gizmore
 */
final class WC_HTML
{
	public static $LEFT_PANEL = true;
	public static $RIGHT_PANEL = true; # 0 auto, 1 enabled, 2 disabled.
	public static $HEADER = true; # true or false
	public static $FOOTER = true; # true or false
	
	public static function wantHeader()
	{
		return self::$HEADER === true;
	}

	public static function displayHeader()
	{
		if (self::$HEADER === false) {
			return '';
		}
		
		if (false === ($module = GWF_Module::getModule('WeChall'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('WeChall'));
		}
		
// 		$logo_url = GWF_WEB_ROOT.'changes.txt';
		$logo_url = GWF_WEB_ROOT.'about_wechall';
		
		return
			'<header id="wc_head">'.PHP_EOL.
				#'<div class="fr">'.self::displayHeaderLogin($module).'</div>'.PHP_EOL.
				'<a href="'.$logo_url.'" id="wc_logo" title="WeChall"></a>'.PHP_EOL.
				'<div id="wc_head_stats">'.PHP_EOL.
					self::displayHeaderSites($module).PHP_EOL.
					self::displayHeaderUsers($module).PHP_EOL.
					self::displayHeaderOnline($module).PHP_EOL.
//					self::displayHeaderLogin($module).PHP_EOL.
				'</div>'.PHP_EOL.
#				self::getFavSiteBar().PHP_EOL.
#				self::getQuickUpdateBar().PHP_EOL.
			'</header>'.PHP_EOL.
			'<div class="cb"></div>'.PHP_EOL;
	}
	
	private static function getFavSiteBar()
	{
		if ('0' === ($uid = GWF_Session::getUserID())) {
			return '';
		}
		
		$sites = WC_SiteFavorites::getFavoriteSites($uid);
		
		if (count($sites) === 0) {
			return '';
		}
		
		$data = array(array(self::lang('th_selfavsite2'), 0));
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			$data[] = array($site->getVar('site_name'), $site->getURL());
		}
		$onchange = 'document.location=this.value;';
		return
			'<div id="wc_qumpbar">'. 
			'<form action="'.GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=FavoriteSites" method="post">'.
			'<div>'.
			self::lang('th_selfavsite').':&nbsp;'.GWF_Select::display('favsites', $data, 0, $onchange).
			sprintf('<noscript><div class="ib"><input type="submit" name="quickjump" value="%s" /></div></noscript>', self::lang('btn_quickjump')).
			'</div>'.
			'</form>'.
			'</div>';
	}
	
	private static function getQuickUpdateBar()
	{
		if ('0' === ($uid = GWF_Session::getUserID())) {
			return '';
		}
		
		$sites = WC_Site::getQuickUpdateSites($uid);
		$back = '';
		if (count($sites) > 0)
		{
			foreach ($sites as $site)
			{
				$site instanceof WC_Site;
				$back .= sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=LinkedSites&amp;quick_update='.$site->getVar('site_id'), $site->displayLogo(20, $site->getVar('site_name'), false) );
			}
			
			return sprintf('<div id="wc_qupdatebar">%s: %s</div>', self::lang('th_quickupdate'), $back);
		}
		return '';
	}
	
	public static function displayHeaderLogin()
	{
		if ( (GWF_Session::isLoggedIn()) ) #|| (!GWF_Session::haveCookies()) )
		{
			return '';
		}
		
		$module = Module_WeChall::instance();
		
		$formhash = '_username_password_bind_ip';
		$formhash = GWF_Password::getToken($formhash);
		$username = $module->lang('th_user_name');
		$password = $module->lang('th_password');
		$bind_ip = $module->lang('th_bind_ip');
		$register = $module->lang('menu_register');
		$forgot = $module->lang('btn_forgot_pw');
		$login = $module->lang('btn_login');
		
		return
		'<div id="header_login" class="wc_head_bigbox">'.PHP_EOL.
		'<div class="wc_head_box">'.PHP_EOL.
		'<form action="'.GWF_WEB_ROOT.'login" method="post" id="wc_toplogin">'.PHP_EOL.
		#'<div>'.GWF_CSRF::hiddenForm($formhash).'</div>'.PHP_EOL.
		'<div><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_user.gif" title="'.$username.'" alt="'.$username.':" />&nbsp;<input type="text" name="username" value="" /></div>'.PHP_EOL.
		'<div><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_pass.gif" title="'.$password.'" alt="'.$password.':" />&nbsp;<input type="password" name="password" value="" /></div>'.PHP_EOL.
		'<div class="le">'.$bind_ip.'&nbsp;<input type="checkbox" name="bind_ip" checked="checked" /></div>'.PHP_EOL.
		'<div class="le">'.
			'<input type="submit" name="login" value="'.$login.'" />'.
// 			'<a href="'.GWF_WEB_ROOT.'register">'.$register.'</a>'.
		'</div>'.PHP_EOL.
		'<div><a href="'.GWF_WEB_ROOT.'recovery">'.$forgot.'</a></div>'.PHP_EOL.
		'</form>'.PHP_EOL.
		'</div></div>'.PHP_EOL;
		
	}
	
	public static function displayHeaderLoginBROKEN(Module_WeChall $module)
	{
		if ( (GWF_User::isLoggedIn()) || (!GWF_Session::haveCookies()) )
		{
			return '';
		}
		
		if (false === ($mod_login = GWF_Module::loadModuleDB('Login', false, true)))
		{
			return '';
		}
		
		$formhash = GWF_Password::getToken('_username_password_bind_ip_login');
		
		return 
			'<form action="'.GWF_WEB_ROOT.'login" method="post" id="wc_toplogin">'.
			'<div>'.GWF_CSRF::hiddenForm($formhash).'</div>'.
			'<div>'.$mod_login->lang('th_username').' <input type="text" name="username" value="" />'.'</div>'.
			'<div>'.$mod_login->lang('th_password').' <input type="password" name="password" value="" />'.'</div>'.
			'<div>'.$mod_login->lang('th_bind_ip').' <input type="checkbox" name="bind_ip" checked="checked" />'.
			'<input type="submit" name="login" value="'.$mod_login->lang('btn_login').'" />'.'</div>'.
			'</form>';
	}
	
	private static function getRevisionText(Module_WeChall $module)
	{
		if (file_exists("rev.txt")) {
			$rev = explode("\n",file_get_contents("rev.txt"));
			return $rev[2];
		}
		return 'REVISION_TXT';
	}
	
	/**
	 * Show the latest active sites
	 * @param Module_WeChall $module
	 * @param unknown_type $amount
	 * @return unknown_type
	 */
	public static function displayHeaderSites(Module_WeChall $module, $amount=8)
	{
		$sites = WC_Site::getActiveSites();
		$count = count($sites);
		
		$back = '<div class="wc_head_bigbox">';
		
		$back .= '<div class="wc_head_title">'.sprintf('<a href="%sactive_sites">%s</a>', GWF_WEB_ROOT, $module->lang('head_sites')).'</div>';
		
		$back .= '<div class="wc_head_box">';
		for ($i = 0; $i < 4; $i++)
		{
			if ($i >= $count) { break; }
			$back .= $sites[$i]->getLink();
		}
		$back .= '</div>';
		
		$back .= '<div class="wc_head_box">';
		for ($i = 4; $i < 8; $i++)
		{
			if ($i >= $count) { break; }
			$back .= $sites[$i]->getLink();
		}
		$back .= '</div>';
		
		$back .= '</div>';
		return $back;
//		$i = 0;
//		$back = '';
//		foreach ($sites as $site)
//		{
////			$back .= ', '.$site->getLink();
//			$back .= $site->getLink();
//			if (++$i > $amount) {
//				break;
//			}
//		}
//		
//		return '<div><span class="wc_head_title">'.$module->lang('head_sites').'</span><span>'.substr($back, 0).'</span></div>';
	}

	public static function displayHeaderUsers(Module_WeChall $module, $amount=8)
	{
		$users = GDO::table('GWF_User')->selectObjects('*', "user_level>0", 'user_regdate DESC', $amount, 0);
		$count = count($users);
		$back = '';
		$back .= '<div class="wc_head_bigbox">';
		
		$back .= '<div class="wc_head_title">'.$module->lang('head_users', array(GWF_WEB_ROOT.'users/with/All/by/user_regdate/DESC/page-1')).'</div>';
		
		$back .= '<div class="wc_head_box">';
		for ($i = 0; $i < 4; $i++)
		{
			if ($i === $count) { break; }
			$user = $users[$i];
			$back .= sprintf('<a href="%s" title="%s">%s</a>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername());
		}
		$back .= '</div>';
		
		$back .= '<div class="wc_head_box">';
		for ($i = 4; $i < 8; $i++)
		{
			if ($i >= $count) { break; }
			$user = $users[$i];
			$back .= sprintf('<a href="%s" title="%s">%s</a>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername());
		}
		$back .= '</div>';
		
		$back .= '</div>';
		return $back;
		
		
//		var_dump($users);
		$back = '';
		foreach ($users as $user)
		{
			$back .= sprintf(', <a href="%s" title="%s">%s</a>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername());
		}
		
//		var_dump($back);
		
		return $module->lang('head_users', array(GWF_WEB_ROOT.'users/with/All/by/user_regdate/DESC/page-1')).'&nbsp;'.substr($back, 2);
	}

//	private static function displayHeaderOnline(Module_WeChall $module, $max=20)
//	{
//		$back = '<div class="wc_head_bigbox" style="max-width:30%;">';
//		$back .= GWF_Notice::getOnlineUsers();
//		$back .= '</div>';
//		
//	}
	
	public static function displayHeaderOnline(Module_WeChall $module, $max=20)
	{
		$sessions = GWF_Session::getOnlineSessions();
		$back = '';
		$text = '';
		$more = '';
		$names = 0;
		$online = 0;
		foreach ($sessions as $sess)
		{
			$sess instanceof GWF_Session;
			$count = $sess->getVar('sessioncount');
			$online += $count;
			if (NULL !== ($user = $sess->getVar('sess_user')))
			{
				if (!$user instanceof GWF_User)
				{
					continue;
				}
				if ( ($user->getID() === NULL) || ($user->isOptionEnabled(GWF_User::HIDE_ONLINE)) )
				{
					continue;
				}
				$names++;
				if ($names <= $max)
				{
					$multi = $count > 1 ? "(x{$count})" : '';
					$text .= sprintf(', <a href="%s" title="%s">%s%s</a>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername(), $multi);
				}
				else
				{
					$more = self::onlineMoreAnchor($module);
					break;
				}
			}
		}
		
// 		$back .= '<div class="wc_head_bigbox" style="max-width:30%;">';
		$back .= '<div class="wc_head_bigbox" style="float:none;">';
		$back .= '<div class="wc_head_title"><a href="'.GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1">'.$module->lang('head_online', array($online)).'</a></div>';
		$back .= '<div class="wc_head_online">';
		
		
		return $back.substr($text,2).$more.'</div></div>'.PHP_EOL;
	}
	
	private static function onlineMoreAnchor(Module_WeChall $module)
	{
		return GWF_HTML::anchor(GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1', ', '.$module->lang('more_online').'…');
	}
	
	##############
	### Panels ###
	##############
	public static function wantLeftPanel()
	{
		return GWF_Session::getOrDefault('WC_LEFT_PANEL', self::$LEFT_PANEL) === true;
	}
	
	public static function displayLeftPanel()
	{
		$wc = Module_WeChall::instance();
		if (self::wantLeftPanel()) {
			return '<div id="wc_left_panel">'.$wc->getMethod('Sidebar')->displayLeft($wc).'</div>';
		}
		return '<div class="fl">'.GWF_Button::add($wc->lang('btn_sidebar_off'), $wc->getMethodURL('Sidebar', '&leftpanel=1')).'</div>';
	}
	
	public static function wantRightPanel()
	{
		return GWF_Session::getOrDefault('WC_RIGHT_PANEL', self::$RIGHT_PANEL) === true;
	}
	
	public static function displayRightPanel()
	{
		$wc = Module_WeChall::instance();
		if (self::wantRightPanel())
		{
			return '<div id="wc_right_panel">'.$wc->getMethod('Sidebar')->displayRight($wc).'</div>';
		}
		return '<div id="wc_right_panel">'.GWF_Button::add($wc->lang('btn_sidebar_off'), $wc->getMethodURL('Sidebar2', '&rightpanel=1')).'</div>';
	}
	
	public static function displaySidebar2()
	{
		$wc = Module_WeChall::instance();
		if (self::wantRightPanel())
		{
			return $wc->getMethod('Sidebar2')->display($wc);
		}
		return '<aside id="wc_sidebar"><div class="wc_side_box"><div class="wc_side_title"><div class="gwf_buttons_outer"><div class="gwf_buttons">'.GWF_Button::add($wc->lang('btn_sidebar_off'), $wc->getMethodURL('Sidebar2', '&rightpanel=1')).'</div></div></div></div></aside>';
	}
	
	##############
	### Footer ###
	##############
	public static function wantFooter()
	{
		return self::$FOOTER;
	}
	
	public static function displayFooter($debug=true)
	{
		$back = '';
		if (self::wantFooter())
		{
			$back .= '<footer id="gwf_footer">';
			$back .= self::displayFooterMenu(Module_WeChall::instance());
			if (!($module = GWF_Module::getModule('Heart')))
			{
				return GWF_HTML::err('ERR_MODULE_MISSING', array('Heart'));
			}
			$back .= '<div id="foot_boxes" class="cf">'.PHP_EOL;
			$codeUrl = 'https://github.com/gizmore/gwf3';
			$back .= '<div class="foot_box">'.self::lang('footer_1', array(date('Y'), $codeUrl)).'</div>'.PHP_EOL;
			$back .= '<div class="foot_box">'.self::lang('footer_2', array($module->cfgUserrecordCount(), GWF_Time::displayDate($module->cfgUserrecordDate()), $module->cfgPagecount())).'</div>'.PHP_EOL;
			$back .= $debug ? '<div class="foot_box">'.self::debugFooter().'</div>'.PHP_EOL : '';
			$back .= '</div>'.PHP_EOL;
			$back .= '</footer>'.PHP_EOL;
		}
		return $back;
	}
	
	private static function debugFooter($precision=4)
	{
		$db = gdo_db();
		$queries = $db->getQueryCount();
		$writes = $db->getQueryWriteCount();
		$t_total = microtime(true)-GWF_DEBUG_TIME_START;
		$t_mysql = $db->getQueryTime();
		$t_php = $t_total - $t_mysql;
		$f = sprintf('%%0.%dfs', (int)$precision);
		$bd = '';#self::debugBrowser();
		$mem = GWF_Upload::humanFilesize(memory_get_peak_usage(true));
		$mods = GWF_Module::getModulesLoaded();
		return sprintf("<div>%d Queries (%d writes) in $f - PHP Time: $f - Total Time: $f. Memory: %s<br/>Modules loaded: %s</div>", $queries, $writes, $t_mysql, $t_php, $t_total, $mem, $mods).$bd;
	}
	
	private static function displayFooterMenu(Module_WeChall $module)
	{
		return $module->templatePHP('wcfootermenu.php');
// 		GWF_HTML::display(self::getRevisionText($module))
	}
	
	############
	### MENU ###
	############
	public static function displayMenu()
	{
		if (false === ($module = GWF_Module::getModule('WeChall'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('WeChall'));
		}
		
		$back = '<nav id="wc_menu">';
		$back .= '<ul>';
		$back .= self::displayMenuLangSelect($module).PHP_EOL;
		$back .= self::displayMenuNews($module).PHP_EOL;
// 		$back .= self::displayMenuAbout($module).PHP_EOL;
		$back .= self::displayMenuLinks($module).PHP_EOL;
		$back .= self::displayMenuSites($module).PHP_EOL;
// 		$back .= self::displayMenuPapers($module).PHP_EOL;
		$back .= self::displayMenuForum($module).PHP_EOL;
		$back .= self::displayMenuRanking($module).PHP_EOL;
		$back .= self::displayMenuChallenges($module).PHP_EOL;
		$back .= self::displayMenuAccount($module).PHP_EOL;
		$back .= self::displayMenuPM($module).PHP_EOL;
// 		$back .= self::displayMenuStats($module).PHP_EOL;
		$back .= self::displayMenuDownload($module).PHP_EOL;
// 		$back .= self::displayMenuChat($module).PHP_EOL;
		$back .= self::displayMenuGroups($module).PHP_EOL;
// 		$back .= self::displayMenuUserPages($module).PHP_EOL;
		$back .= self::displayMenuAdmin($module).PHP_EOL;
		$back .= self::displayMenuLogout($module).PHP_EOL;
		
		$back .= '</ul></nav>';
		$back .= '<div class="cl"></div>';
		return $back;
	}
	
	public static function displayMenuLangSelect(Module_WeChall $module)
	{
//		return '<li id="wc_lang_sel">'.GWF_Website::getSwitchLangSelect(true).'</li>'.PHP_EOL;
		return '<li id="wc_lang_sel">'.GWF_LangSwitch::select().'</li>'.PHP_EOL;
	}

	public static function displayMenuNews(Module_WeChall $module)
	{
		$sel = Common::getGet('mo') === 'News' ? ' class="wc_menu_sel"' : '';
		$count = $module->getNewsCount();
		$app = $count === 0 ? '' : sprintf('[%d]', $count);
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'news">'.$module->lang('menu_news').$app.'</a></li>';
	}

	public static function displayMenuAbout(Module_WeChall $module)
	{
		$sel = $module->isMethodSelected('About') ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'about_wechall">'.$module->lang('menu_about').'</a></li>';
	}
	
	public static function displayMenuLinks(Module_WeChall $module)
	{
		$sel = Common::getGet('mo') === 'Links' ? ' class="wc_menu_sel"' : '';
		if (false !== ($user = GWF_Session::getUser())) {
			$count = self::getUnreadLinksCount($user);
		} else {
			$count = 0;
		}
		$app = $count > 0 ? '['.$count.']' :'';
		if ($sel !== '') {
			self::$LEFT_PANEL = self::$RIGHT_PANEL = false;
		}
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'links">'.$module->lang('menu_links').$app.'</a></li>';
	}
	
	public static function getUnreadLinksCount($user)
	{
		$db = gdo_db();
		$table = GWF_TABLE_PREFIX.'links';
		$conditions = self::getLinksUnreadConditions($user);
		$query = "SELECT COUNT(*) c FROM $table WHERE $conditions";
		if (false === ($result = $db->queryFirst($query))) {
			return 0;
		} else {
			return (int) $result['c'];
		}
	}
	
	private static function getLinksUnreadConditions($user)
	{
		return sprintf('(%s) AND (%s)', self::getLinkPermQuery($user), self::getLinkUnreadQuery($user));
	}
	
	private static function getLinkPermQuery($user)
	{
		$mod = 0x02;
		$member = 0x08;
		$private = 0x10;
		if (!is_object($user)) { # Guest
			return "link_score=0 AND link_gid=0 AND (link_options&$private=0) AND (link_options&$member=0) AND (link_options&$mod=0)";
		}
		else if ($user->isStaff()) {
			return "1";
		}
		else { # Member
			$ug = GWF_TABLE_PREFIX.'usergroup';
			$level = $user->getVar('user_level');
			$uid = $user->getID();
			return "((link_score<=$level) AND ((link_gid=0) OR (link_gid=(SELECT ug_groupid FROM $ug WHERE ug_userid=$uid AND ug_groupid=link_gid))) AND (link_options&$private=0 OR link_user=$uid))";
		}
	}
	
	private static function getLinkUnreadQuery($user)
	{
		if (is_object($user) && $user->isUser())
		{
			$user instanceof GWF_User;
			$uid = $user->getVar('user_id');
			$data = $user->getUserData();
			$mark = isset($data['gwf_links_readmark']) ? $data['gwf_links_readmark'] : $user->getVar('user_regdate');
			return "(link_date>'$mark') AND (link_readby NOT LIKE '%:$uid:%')";# AND (link_date>'$regdate')";
		}
		else
		{
			$time = 60*60*24;
			$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time() - $time);
			return "link_date>'$cut'";
		}
	}
	
	public static function displayMenuSites(Module_WeChall $module)
	{
		switch (Common::getGet('me','')) {
			case 'Sites': case 'SiteDetails': case 'SiteMasters': case 'SiteRankings': case 'SiteEdit':
				$sel = true; break;
			default:
				$sel = false; break;
		}
		$sel = $sel ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'active_sites">'.$module->lang('menu_sites').'</a></li>';
	}
	
	public static function displayMenuPapers(Module_WeChall $module)
	{
		$sel = Common::getGetString('mo') === 'PageBuilder';
		$sel = $sel ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'pages">'.$module->lang('menu_papers').'</a></li>';
	}
	
	public static function getUnreadThreadCount($user)
	{
		if ('0' === ($uid = $user->getVar('user_id')))
		{
			return 0;
		}
		$threads = GWF_TABLE_PREFIX.'forumthread';
		$grp = GWF_TABLE_PREFIX.'usergroup';
		$permquery = "(thread_gid=0 OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=thread_gid))";
		
		$data = $user->getUserData();
		$stamp = isset($data['GWF_FORUM_STAMP']) ? $data['GWF_FORUM_STAMP'] : $user->getVar('user_regdate');
		$regtimequery = sprintf('thread_lastdate>=\'%s\'', $stamp);
		$query = "SELECT COUNT(*) c FROM $threads WHERE (thread_postcount>0 AND ($permquery) AND ($regtimequery OR thread_force_unread LIKE '%:$uid:%') AND (thread_unread NOT LIKE '%:$uid:%') AND (thread_options&4=0))";
		$result = gdo_db()->queryFirst($query);
		return (int)$result['c'];
	}

	public static function displayMenuForum(Module_WeChall $module)
	{
		$sel = Common::getGet('mo') === 'Forum' ? ' class="wc_menu_sel"' : '';
		if (false !== ($user = GWF_Session::getUser()))
		{
			$count = self::getUnreadThreadCount($user);
		}
		else
		{
			$count = 0; 
		}
		$app = $count === 0 ? '' : '['.$count.']';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'forum">'.$module->lang('menu_forum').$app.'</a></li>';
	}
	
	public static function displayMenuRanking(Module_WeChall $module)
	{
		switch (Common::getGet('me',''))
		{
			case 'Ranking': case 'RankingActive': case 'RankingCountry': case 'RankingLang': case 'ScoringFaq': case 'SiteRankings': case 'SiteMasters':
				$sel = true; break;
			default:
				$sel = false; break;
		}
		$sel = $sel ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'ranking">'.$module->lang('menu_ranking').'</a></li>';
	}
	
	public static function displayMenuRankingNSC(Module_WeChall $module)
	{
		switch (Common::getGet('me',''))
		{
			case 'Ranking': case 'RankingCountry': case 'RankingLang': case 'ScoringFaq': case 'SiteRankings': case 'SiteMasters':
				$sel = true; break;
			default:
				$sel = false; break;
		}
		$sel = $sel ? ' class="wc_menu_sel"' : '';
		$wc = WC_Site::getWeChall();
		return '<li><a'.$sel.' href="'.$wc->hrefRanking().'">'.$module->lang('menu_ranking').'</a></li>';
	}
	
	public static function displayMenuChallenges(Module_WeChall $module)
	{
		$sel = $module->isMethodSelected('Challs') ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'challs">'.$module->lang('menu_challs').'</a></li>';
	}
	
	public static function displayMenuChallengesNSC(Module_WeChall $module)
	{
		$sel = $module->isMethodSelected('Sites') ? ' class="wc_menu_sel"' : '';
		$href = WC_Site::getWeChall()->hrefWarboxes();
		return '<li><a'.$sel.' href="'.$href.'">'.$module->lang('menu_challs').'</a></li>';
	}
	
	public static function displayMenuAccount(Module_WeChall $module)
	{
		if ( (false === ($user = GWF_Session::getUser())) ) {
			return '';
		}
		if ($user->isWebspider()) {
			return '<!-- WEBSPIDER -->';
		}
		$account = Common::getGet('mo') === 'Account';
		$link_site = $module->isMethodSelected('LinkedSites');
		$forum_opts = Common::getGet('mo') === 'Forum' && Common::getGet('me') === 'Options';
		$pm_opts = Common::getGet('mo') === 'PM' && Common::getGet('me') === 'Options';
		$own_profile = Common::getGet('mo') === 'Profile' && (Common::getGet('username') === $user->getVar('user_name') || Common::getGet('me') === 'Form');
		$favs = $module->isMethodSelected('FavoriteSites');
		$sel = $account || $link_site || $forum_opts || $pm_opts || $own_profile || $favs ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'linked_sites">'.$module->lang('menu_account').'</a></li>';
	}
	
	public static function displayMenuPM(Module_WeChall $module)
	{
		if ( (false === ($user = GWF_Session::getUser())) || ($user->isWebspider()) ) {
			return '';
		}
		$sel = Common::getGet('mo') === 'PM' ? ' class="wc_menu_sel"' : '';
		$count = self::getUnreadPMCount($user);
		$app = $count === 0 ? '' : '['.$count.']';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'pm">'.$module->lang('menu_pm').$app.'</a></li>';
	}
	public static function getUnreadPMCount(GWF_User $user)
	{
		$db = gdo_db();
		$pms = GWF_TABLE_PREFIX.'pm';
		$uid = $user->getVar('user_id');
		$query = "SELECT COUNT(*) c FROM $pms WHERE pm_to=$uid AND (pm_options&1=0)";
		$result = $db->queryFirst($query, false);
		return (int) $result['c'];
	}
	
	public static function displayMenuStats(Module_WeChall $module)
	{
		if ( (false === ($user = GWF_Session::getUser())) || ($user->isWebspider()) )
		{
			return '';
//			return self::displayMenuStatsGuest($module);
		}
		$sel = Common::getGet('me') === 'Stats' ? ' class="wc_menu_sel"' : '';
		$href = GWF_WEB_ROOT.'stats/'.$user->urlencode('user_name');
		return sprintf('<li><a'.$sel.' href="%s">%s</a></li>', $href, $module->lang('menu_stats'));
	}
	
	public static function displayMenuStatsGuest(Module_WeChall $module)
	{
		$sel = Common::getGet('me') === 'Stats' ? ' class="wc_menu_sel"' : '';
		$href = GWF_WEB_ROOT.'stats';
		return sprintf('<li><a'.$sel.' href="%s">%s</a></li>', $href, $module->lang('menu_stats2'));
	}
	
	public static function displayMenuDownload(Module_WeChall $module)
	{
		$user = GWF_User::getStaticOrGuest();
		if ($user->isWebspider())
		{
			return '';
		}
		$sel = Common::getGet('mo') === 'Download' ? ' class="wc_menu_sel"' : '';
		$href =  GWF_WEB_ROOT.'downloads';
		return sprintf('<li><a'.$sel.' href="%s">%s</a></li>', $href, $module->lang('menu_download'));
	}
	
	public static function displayMenuLogout(Module_WeChall $module)
	{
		if (false !== ($user = (GWF_Session::getUser())))
		{
			return
				'<li><a href="'.GWF_WEB_ROOT.'logout">'.$module->lang('menu_logout').'</a></li>'.
			 	'<li><a class="profile_logout" href="/profile/'.$user->urlencode('user_name').'">['.$user->displayUsername().']</a></li>';
		}
		else
		{
			$sel = Common::getGet('mo') === 'Register' ? ' class="wc_menu_sel"' : '';
			return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'register">'.$module->lang('menu_register').'</a></li>';
		}
	}
	
	public static function displayMenuChat(Module_WeChall $module)
	{
		$sel = Common::getGet('mo')==='Chat' ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'irc_chat">'.$module->lang('menu_chat').'</a></li>';
		
	}

	public static function displayMenuGroups(Module_WeChall $module)
	{
		if (GWF_User::isLoggedIn()) {
			$sel = Common::getGet('mo')==='Usergroups' ? ' class="wc_menu_sel"' : '';
			return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'my_groups">'.$module->lang('menu_groups').'</a></li>';
		}
	}
	
	public static function displayMenuUserPages(Module_WeChall $module)
	{
		$sel = Common::getGet('mo')==='Pagebuilder' ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'pages">'.$module->lang('menu_userpages').'</a></li>';
	}
	
	public static function displayMenuAdmin(Module_WeChall $module)
	{
		$sel = '';
		if (Common::getGet('mo')==='Admin')
		{
			$sel = ' class="wc_menu_sel"';
			self::$LEFT_PANEL = false;
			self::$RIGHT_PANEL = false;
		}
		return GWF_User::isAdminS() ? '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'nanny">'.$module->lang('menu_admin').'</a></li>' : '';
	}
	
	public static function lang($key, array $args=NULL)
	{
		return Module_WeChall::instance()->getLanguage()->lang($key, $args);
	}
	
	public static function message($key, array $args=NULL)
	{
		$msg = Module_WeChall::instance()->getLanguage()->lang($key, $args);
		return GWF_HTML::message('WeChall', $msg);
	}
	
	public static function error($key, array $args=NULL)
	{
		$msg = Module_WeChall::instance()->getLanguage()->lang($key, $args);
		return GWF_HTML::error('WeChall', $msg);
	}
	
	public static function box($text, $title=false)
	{
		$back = '';
		if ($title !== false)
		{
			$back .= '<div class="box_t">'.$title.'</div>';
		}
		$back .= '<div class="box">'.$text.'</div>';
		return $back;
	}
	
	public static function button($text, $href, $sel=false)
	{
		return GWF_Button::generic(self::lang($text), $href, 'generic', '', $sel);
	}

	public static function tableRowForm($th, $td)
	{
		if ($td === '') {
			return '';
		}
		return
			GWF_Table::rowStart().
			'<th>'.$th.'</th>'.PHP_EOL.
			'<td>'.$td.'</td>'.PHP_EOL.
			GWF_Table::rowEnd();
	}

	public static function accountButtons()
	{
		return Module_WeChall::instance()->templatePHP('wcaccountbuttons.php');
	}
	
	public static function rankingPageButtons()
	{
// 		return Module_WeChall::instance()->templatePHP('wcrankingbuttons.php');
		
		echo '<nav>'.PHP_EOL;
		echo '<div class="gwf_buttons_outer">'.PHP_EOL;
		echo '<div class="gwf_buttons">'.PHP_EOL;
		echo GWF_Button::generic(self::lang('btn_global_rank'), GWF_WEB_ROOT.'ranking', 'generic', '', Common::getGet('me')==='Ranking');
		echo GWF_Button::generic(self::lang('btn_active_rank'), GWF_WEB_ROOT.'ranking_active', 'generic', '', Common::getGet('me')==='RankingActive');
		echo GWF_Button::generic(self::lang('btn_site_rank'), GWF_WEB_ROOT.'site/ranking/for/1/WeChall', 'generic', '', Common::getGet('me')==='SiteRankings');
		echo GWF_Button::generic(self::lang('btn_lang_rank'), GWF_WEB_ROOT.'lang_ranking/en', 'generic', '', Common::getGet('me')==='RankingLang');
		echo GWF_Button::generic(self::lang('btn_country_rank'), GWF_WEB_ROOT.'country_ranking', 'generic', '', Common::getGet('me')==='RankingCountry');
		echo GWF_Button::generic(self::lang('btn_tag_rank'), GWF_WEB_ROOT.'category_ranking', 'generic', '', Common::getGet('me')==='RankingTag');
		echo GWF_Button::generic(self::lang('btn_site_masters'), GWF_WEB_ROOT.'site_masters', 'generic', '', Common::getGet('me')==='SiteMasters');
#		echo GWF_Button::generic(self::lang('btn_grp_rank'), GWF_WEB_ROOT.'usergroup_ranking');
		echo GWF_Button::generic(self::lang('btn_stats'), GWF_WEB_ROOT.'stats');
		echo '</div>'.PHP_EOL;
		echo '</div>'.PHP_EOL;
		echo '</nav>'.PHP_EOL;
	}
	
	public static function styleSelected()
	{
		return ' background: #ffb;';
	}

	public static function getColorForPercent($percent)
	{
		static $colors = array(
			'ee0000', // 0
			'd61400', 'be2900', 'a73d00', 
			'8f5200', '776600', '5f7a00', 
			'478f00', '30a300', '18b800',
			'00cc00' // 10
		);
		return $colors[Common::clamp(intval(round($percent/10)), 0, 10)];
	}
	
	public static function displayMobileHeader()
	{
		$tVars = array(
		);
		return GWF_Template::templatePHPMain('mobile_header.php', $tVars);
	}

	public static function displayMobileFooter()
	{
		$tVars = array(
		);
		return GWF_Template::templatePHPMain('mobile_footer.php', $tVars);
	}
}

