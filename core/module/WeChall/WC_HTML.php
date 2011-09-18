<?php
##################################
### --- WRAP OLD FUNCTIONS --- ###
##################################
function html_head($title="WeChall", $withSidebar=false, $strict=true, $scripts=array(), $xhtml=true, $css=array())
{
	GWF_Website::setPageTitle($title);
	WC_HTML::$LEFT_PANEL = $withSidebar;
	WC_HTML::$RIGHT_PANEL = $withSidebar;
	foreach ($css as $path) {
		GWF_Website::addCSS($path);
	}
}
function htmlDisplayError($msg, $log=true) { echo GWF_HTML::error('WeChall', $msg, $log); return false; }
function htmlDisplayMessage($msg, $log=true) { echo GWF_HTML::message('WeChall', $msg, $log); return true; }
function htmlSendToLogin() { echo GWF_HTML::err('ERR_LOGIN_REQUIRED'); GWF_Website::redirect(GWF_WEB_ROOT.'login'); }
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
		
		return
			'<div id="wc_head">'.PHP_EOL.
				#'<div class="fr">'.self::displayHeaderLogin($module).'</div>'.PHP_EOL.
				'<a href="'.GWF_WEB_ROOT.'changes.txt" id="wc_logo" title="'.GWF_HTML::display(self::getRevisionText($module)).'"></a>'.PHP_EOL.
				'<div id="wc_head_stats">'.PHP_EOL.
					self::displayHeaderSites($module).PHP_EOL.
					self::displayHeaderUsers($module).PHP_EOL.
					self::displayHeaderOnline($module).PHP_EOL.
//					self::displayHeaderLogin($module).PHP_EOL.
				'</div>'.PHP_EOL.
#				self::getFavSiteBar().PHP_EOL.
#				self::getQuickUpdateBar().PHP_EOL.
			'</div>'.PHP_EOL.
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
	
	private static function displayHeaderLogin(Module_WeChall $module)
	{
		if (GWF_User::isLoggedIn()) {
			return '';
		}
		
		if (false === ($mod_login = GWF_Module::getModule('Login'))) {
			return '';
		}
//		if (false === ($met_login = $mod_login->getMethod('Form'))) {
//			return '';
//		}
		
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
	private static function displayHeaderSites(Module_WeChall $module, $amount=8)
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

	private static function displayHeaderUsers(Module_WeChall $module, $amount=8)
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
//		$back .= GWF_SmartyFile::instance()->__call('module_Heart_beat', array());
//		$back .= '</div>';
//		
//	}
	

	private static function displayHeaderOnline(Module_WeChall $module, $max=20)
	{
		$sessions = GWF_Session::getOnlineSessions();
		$back = '';
		$back = '';
		$back .= '<div class="wc_head_bigbox" style="max-width:30%;">';
		$back .= '<div class="wc_head_title"><a href="'.GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1">'.$module->lang('head_online', array(count($sessions))).'</a></div>';
		$back .= '<div class="wc_head_online">';

		$text = '';
		$more = '';
		$i = 0;
		foreach ($sessions as $sess)
		{
			$sess instanceof GWF_Session;
			if (NULL !== ($user = $sess->getVar('sess_user', false)))
			{
				if ( ($user->getID() === NULL) || ($user->isOptionEnabled(GWF_User::HIDE_ONLINE)) )
				{
					continue;
				}
				$i++;
				if ($i <= $max) {
					$text .= sprintf(', <a href="%s" title="%s">%s</a>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername());
				}
				else {
					$more = self::onlineMoreAnchor($module);
					break;
				}
			}
		}
		
		return $back.substr($text,2).$more.'</div></div>'.PHP_EOL;
	}
	
	private static function onlineMoreAnchor(Module_WeChall $module)
	{
		return GWF_HTML::anchor(GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1', $module->lang('more').'...');
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
		if (self::wantRightPanel()) {
			return '<div id="wc_right_panel">'.$wc->getMethod('Sidebar')->displayRight($wc).'</div>';
		}
		return '<div id="wc_right_panel">'.GWF_Button::add($wc->lang('btn_sidebar_off'), $wc->getMethodURL('Sidebar2', '&rightpanel=1')).'</div>';
	}
	
	public static function displaySidebar2()
	{
		$wc = Module_WeChall::instance();
		if (self::wantRightPanel()) {
			return $wc->getMethod('Sidebar2')->display($wc);
		}
		else {
			return '<div id="wc_sidebar"><div class="wc_side_box"><div class="wc_side_title"><div class="gwf_buttons_outer"><div class="gwf_buttons">'.GWF_Button::add($wc->lang('btn_sidebar_off'), $wc->getMethodURL('Sidebar2', '&rightpanel=1')).'</div></div></div></div></div>';
		}
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
		if (!self::wantFooter()) {
			return '';
		}
		if (false === ($module = GWF_Module::getModule('Heart'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Heart'));
		}
		
		$back = '<div id="gwf_footer">';
		$back .= self::displayFooterMenu(Module_WeChall::instance());
		$back .= '<div id="foot_boxes">'.PHP_EOL;
		$back .= '<div class="foot_box">'.self::lang('footer_1').'</div>'.PHP_EOL;
		$back .= '<div class="foot_box">'.self::lang('footer_2', array($module->cfgUserrecordCount(), GWF_Time::displayDate($module->cfgUserrecordDate()), $module->cfgPagecount())).'</div>'.PHP_EOL;
		$back .= $debug ? '<div class="foot_box">'.self::debugFooter().'</div>'.PHP_EOL : '';
		$back .= '</div>'.PHP_EOL;
		$back .= '<div class="cl"></div>'.PHP_EOL;
		$back .= '</div>'.PHP_EOL;
		return $back;
	}
	
	private static function debugFooter($precision=4)
	{
		$db = gdo_db();
		$queries = $db->getQueryCount();
		$t_total = microtime(true)-GWF_DEBUG_TIME_START;
		$t_mysql = $db->getQueryTime();
		$t_php = $t_total - $t_mysql;
		$f = sprintf('%%0.%dfs', (int)$precision);
		$bd = '';#self::debugBrowser();
		$mem = GWF_Upload::humanFilesize(memory_get_peak_usage(true));
		$mods = GWF_Module::getModulesLoaded();
		return sprintf("<div>%d Queries in $f - PHP Time: $f - Total Time: $f. Memory: %s<br/>Modules loaded: %s</div>", $queries, $t_mysql, $t_php, $t_total, $mem, $mods).$bd;
	}
	
	private static function displayFooterMenu(Module_WeChall $module)
	{
		return
		'<div id="gwf_foot_menu">'.PHP_EOL.
			'<a href="'.GWF_WEB_ROOT.'news">'.$module->lang('menu_news').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'about_wechall">'.$module->lang('menu_about').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'join_us">'.$module->lang('menu_join').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'links">'.$module->lang('menu_links').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'active_sites">'.$module->lang('menu_sites').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'forum">'.$module->lang('menu_forum').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'ranking">'.$module->lang('menu_ranking').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'challs">'.$module->lang('menu_challs').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'register">'.$module->lang('menu_register').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'irc_chat">'.$module->lang('menu_chat').'</a>'.PHP_EOL.
			'| <a href="'.GWF_WEB_ROOT.'contact">'.$module->lang('menu_contact').'</a>'.PHP_EOL.
		'</div>'.PHP_EOL;
	}
	
	############
	### MENU ###
	############
	public static function displayMenu()
	{
		if (false === ($module = GWF_Module::getModule('WeChall'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('WeChall'));
		}
		
		$back = '<div id="wc_menu">';
		$back .= '<ul>';
		$back .= self::displayMenuLangSelect($module).PHP_EOL;
		$back .= self::displayMenuNews($module).PHP_EOL;
		$back .= self::displayMenuAbout($module).PHP_EOL;
		$back .= self::displayMenuLinks($module).PHP_EOL;
		$back .= self::displayMenuSites($module).PHP_EOL;
		$back .= self::displayMenuForum($module).PHP_EOL;
		$back .= self::displayMenuRanking($module).PHP_EOL;
		$back .= self::displayMenuChallenges($module).PHP_EOL;
		$back .= self::displayMenuAccount($module).PHP_EOL;
		$back .= self::displayMenuPM($module).PHP_EOL;
		$back .= self::displayMenuStats($module).PHP_EOL;
		$back .= self::displayMenuDownload($module).PHP_EOL;
		$back .= self::displayMenuChat($module).PHP_EOL;
		$back .= self::displayMenuGroups($module).PHP_EOL;
		$back .= self::displayMenuAdmin($module).PHP_EOL;
		$back .= self::displayMenuLogout($module).PHP_EOL;
		
		$back .= '</ul></div>';
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
		if (is_object($user))
		{
			$user instanceof GWF_User;
			$uid = $user->getVar('user_id');
			$data = $user->getUserData();
			$mark = isset($data['gwf_links_readmark']) ? $data['gwf_links_readmark'] : $user->getVar('user_regdate');
			return "(link_date>'$mark') AND (link_readby NOT LIKE '%:$uid:%')";# AND (link_date>'$regdate')";
		}
		else
		{
			$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time() - $this->cfgGuestUnreadTime());
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
	
	public static function getUnreadThreadCount($user)
	{
		$uid = $user->getVar('user_id');
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
		switch (Common::getGet('me','')) {
			case 'Ranking': case 'RankingCountry': case 'RankingLang': case 'ScoringFaq': case 'SiteRankings': case 'SiteMasters':
				$sel = true; break;
			default:
				$sel = false; break;
		}
		$sel = $sel ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'ranking">'.$module->lang('menu_ranking').'</a></li>';
	}
	
	public static function displayMenuChallenges(Module_WeChall $module)
	{
		$sel = $module->isMethodSelected('Challs') ? ' class="wc_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'challs">'.$module->lang('menu_challs').'</a></li>';
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
	private static function getUnreadPMCount(GWF_User $user)
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
		if (false !== ($user = (GWF_Session::getUser()))) {
			return '<li><a href="'.GWF_WEB_ROOT.'logout">'.$module->lang('menu_logout').'['.$user->displayUsername().']</a></li>';
		} else {
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
//		$args = func_get_args();
//		unset($args[0]);
		return Module_WeChall::instance()->getLanguage()->lang($key, $args);
	}
	
	public static function message($key, array $args=NULL)
	{
//		$args = func_get_args();
//		unset($args[0]);
		$msg = Module_WeChall::instance()->getLanguage()->lang($key, $args);
		return GWF_HTML::message('WeChall', $msg);
	}
	
	public static function error($key, array $args=NULL)
	{
//		$args = func_get_args();
//		unset($args[0]);
		$msg = Module_WeChall::instance()->getLanguage()->lang($key, $args);
		return GWF_HTML::error('WeChall', $msg);
	}
	
	public static function box($text, $title=false)
	{
		$back = '';
		if ($title !== false) {
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
		$mo = Common::getGet('mo');
		$me = Common::getGet('me');
		$user = GWF_Session::getUser();
		
		echo '<div class="gwf_buttons_outer">'.PHP_EOL;
		echo '<div class="gwf_buttons">'.PHP_EOL;
		echo WC_HTML::button('btn_linked_sites', GWF_WEB_ROOT.'linked_sites', $me==='LinkedSites');
		echo WC_HTML::button('btn_wc_settings', GWF_WEB_ROOT.'wechall_settings', $me==='WeChallSettings');
		echo WC_HTML::button('btn_account', GWF_WEB_ROOT.'account', $mo==='Account'&&$me==='Form');
		echo WC_HTML::button('btn_edit_profile', GWF_WEB_ROOT.'profile_settings', $mo==='Profile'&&$me==='Form');
		echo WC_HTML::button('btn_guestbook', GWF_WEB_ROOT.'index.php?mo=WeChall&me=CreateGB', $mo==='Guestbook'||$me==='CreateGB');
		echo WC_HTML::button('btn_forum_settings', GWF_WEB_ROOT.'forum/options', $mo==='Forum'&&$me==='Options');
		echo WC_HTML::button('btn_pm_settings', GWF_WEB_ROOT.'pm/options', $mo==='PM'&&$me==='Options');
		echo WC_HTML::button('btn_delete_account', GWF_WEB_ROOT.'account/delete', $mo==='Account'&&$me==='Delete');
		echo WC_HTML::button('btn_view_profile', GWF_WEB_ROOT.'profile/'.$user->urlencode('user_name'));
//		echo WC_HTML::button('btn_view_groups', GWF_WEB_ROOT.'my_groups');
		echo '</div>'.PHP_EOL;
		echo '</div>'.PHP_EOL;
	}
	
	public static function rankingPageButtons()
	{
		echo '<div class="gwf_buttons_outer">'.PHP_EOL;
		echo '<div class="gwf_buttons">'.PHP_EOL;
		echo GWF_Button::generic(self::lang('btn_global_rank'), GWF_WEB_ROOT.'ranking', 'generic', '', Common::getGet('me')==='Ranking');
		echo GWF_Button::generic(self::lang('btn_site_rank'), GWF_WEB_ROOT.'site/ranking/for/1/WeChall', 'generic', '', Common::getGet('me')==='SiteRankings');
		echo GWF_Button::generic(self::lang('btn_lang_rank'), GWF_WEB_ROOT.'lang_ranking/en', 'generic', '', Common::getGet('me')==='RankingLang');
		echo GWF_Button::generic(self::lang('btn_country_rank'), GWF_WEB_ROOT.'country_ranking', 'generic', '', Common::getGet('me')==='RankingCountry');
		echo GWF_Button::generic(self::lang('btn_tag_rank'), GWF_WEB_ROOT.'category_ranking', 'generic', '', Common::getGet('me')==='RankingTag');
		echo GWF_Button::generic(self::lang('btn_site_masters'), GWF_WEB_ROOT.'site_masters', 'generic', '', Common::getGet('me')==='SiteMasters');
#		echo GWF_Button::generic(self::lang('btn_grp_rank'), GWF_WEB_ROOT.'usergroup_ranking');
		echo '</div>'.PHP_EOL;
		echo '</div>'.PHP_EOL;
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
}

?>