<?php
/**
 * Toggle Panel visibility.
 * Show the panels. (moved from WC_HTML)
 * @deprecated
 * @author gizmore
 * @version 1.0
 */
final class WeChall_Sidebar extends GWF_Method
{
	/**
	 * toggle panels
	 * @see core/inc/GWF_Method#execute($this->_module)
	 */
	public function execute()
	{
		if (false !== ($state = Common::getGet('leftpanel'))) {
			GWF_Session::set('WC_LEFT_PANEL', $state > 0);
			GWF_Website::redirectBack();
		}
		elseif (false !== ($state = Common::getGet('rightpanel'))) {
			GWF_Session::set('WC_RIGHT_PANEL', $state > 0);
			GWF_Website::redirectBack();
		}
	}

	/**
	 * Show the right panel, holding sites and general stuff.
	 * @param Module_WeChall $module
	 * @return string html
	 */
	public function displayRight()
	{
		return
			$this->rightPanelStats().PHP_EOL.
			$this->rightPanelSites().PHP_EOL;
	}

	private function rightPanelStats()
	{
		$mod_forum = GWF_Module::getModule('Forum');
		
		$hideBTN = GWF_Button::delete($this->getMethodHref('&rightpanel=0'), $this->_module->lang('btn_sidebar_on'));
		$back = sprintf('<div>%s%s</div>', $hideBTN, $this->_module->lang('rp_stats')).PHP_EOL;
		$back .= '<ol>'.PHP_EOL;
		$back .= '<li><a href="'.GWF_WEB_ROOT.'active_sites">'.$this->_module->lang('rp_sitecount', array(count(WC_Site::getActiveSites()))).'</a></li>'.PHP_EOL;
		$back .= '<li><a href="'.GWF_WEB_ROOT.'challs">'.$this->_module->lang('rp_challcount', array(GDO::table('WC_Challenge')->countRows())).'</a></li>'.PHP_EOL;
		$back .= '<li><a href="'.GWF_WEB_ROOT.'forum">'.$this->_module->lang('rp_postcount', array($mod_forum->cfgPostCount())).'</a></li>'.PHP_EOL;
		$back .= '<li><a href="'.GWF_WEB_ROOT.'users">'.$this->_module->lang('rp_usercount', array(GDO::table('GWF_User')->countRows())).'</a></li>'.PHP_EOL;
		$back .= '</ol>'.PHP_EOL;
		return $back;
	}
	
	private function rightPanelSites()
	{
		$sites = WC_Site::getActiveSites();
//		$sites = GDO::table('WC_Site')->select("site_status='up' OR site_status='down'");
		if (count($sites) === 0) {
			return '';
		}
		
		$back = sprintf('<div>%s</div>', $this->_module->lang('rp_sites', array(count($sites)))).PHP_EOL;
		$back .= '<ol>'.PHP_EOL;
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			$back .= sprintf('<li>%s</li>', $site->getLink()).PHP_EOL;
		}
		$back .= '</ol>'.PHP_EOL;
		return $back;
	}
	
	/**
	 * Show the left panel, holding user stuff.
	 * @param Module_WeChall $module
	 * @return string html
	 */
	public function displayLeft()
	{
		return
			$this->leftPanelLanguage().PHP_EOL.
			$this->leftPanelTop10().PHP_EOL.
			$this->leftPanelLastActive().PHP_EOL.
			$this->leftPanelOnline().PHP_EOL.
			'';
	}
	
	private function leftPanelTop10()
	{
		$hideBTN = GWF_Button::delete($this->getMethodHref('&leftpanel=0'), $this->_module->lang('btn_sidebar_on'));
		
		$users = GDO::table('GWF_User')->selectObjects('*', 'user_options&0x10000000=0', 'user_level DESC', 10);
		if (count($users) === 0) {
			return $hideBTN;
		}
		
		$back = sprintf('<div>%s%s</div>', $hideBTN, $this->_module->lang('rp_topusers', array(10))).PHP_EOL;
		$back .= '<ol>'.PHP_EOL;
		foreach ($users as $user)
		{
			$back .= sprintf('<li><a href="%s" title="%s">%s</a></li>', $user->getProfileHREF(), $this->_module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername()).PHP_EOL;
		}
		$back .= '</ol>'.PHP_EOL;
		return $back;
	}
	
	private function leftPanelLastActiveOLD($amount=20)
	{
		$db = gdo_db();
		$amount = (int) $amount;
		$u = GWF_TABLE_PREFIX.'user';
		$h = GWF_TABLE_PREFIX.'wc_user_history';
		$query = "SELECT user_id,user_name,user_level,userhist_comment FROM $h JOIN $u ON user_id=userhist_uid GROUP BY user_id ORDER BY userhist_date DESC LIMIT $amount";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}
#		$users = GDO::table('WC_UserHistory')->selectColumn('user_name', '', 'userhist_date DESC');
		$back = sprintf('<div>%s</div>', $this->_module->lang('rp_last_active', array($amount))).PHP_EOL;

		$back .= '<ol>';
		
		$txtts = $this->_module->lang('th_totalscore');
		
		while (false !== ($row = $db->fetchRow($result)))
		{
			$href = GWF_WEB_ROOT.'profile/'.urlencode($row[1]);
			$title = sprintf('%s: %s; %s', $txtts, $row[2], GWF_HTML::display($row[3]));
			$back .= sprintf('<li><a href="%s" title="%s">%s</a></li>', $href, $title, GWF_HTML::display($row[1]));
		}
		$back .= '</ol>';
		return $back;
	}
	
	private function leftPanelLastActive($amount=20)
	{
		$db = gdo_db();
		$amount = (int) $amount;
		$u = GWF_TABLE_PREFIX.'user';
		$r = GWF_TABLE_PREFIX.'wc_regat';
		$s = GWF_TABLE_PREFIX.'wc_site';
		$query = "SELECT DISTINCT user_id, user_name, user_level, regat_solved, site_name FROM $r JOIN $u ON user_id=regat_uid JOIN $s ON site_id=regat_sid ORDER BY regat_lastdate DESC LIMIT $amount";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}
#		$users = GDO::table('WC_UserHistory')->selectColumn('user_name', '', 'userhist_date DESC');
		$back = sprintf('<div>%s</div>', $this->_module->lang('rp_last_active', array($amount))).PHP_EOL;

		$back .= '<ol>';
		
//		$txtts = $this->_module->lang('th_totalscore');
		
		while (false !== ($row = $db->fetchRow($result)))
		{
			$href = GWF_WEB_ROOT.'profile/'.urlencode($row[1]);
//			$title = sprintf('%s: %s; %s', $txtts, $row[2], GWF_HTML::display($row[3]));
			$title = $this->_module->lang('li_last_active', array(GWF_HTML::display($row[1]), round($row[3]*100, 2)), GWF_HTML::display($row[4]));
			$back .= sprintf('<li><a href="%s" title="%s">%s</a></li>', $href, $title, GWF_HTML::display($row[1]));
		}
		$back .= '</ol>';
		return $back;
	}
	
	private function leftPanelOnline()
	{
		$back = '';
		
		$cut = $this->_module->cfgLastActiveTime();
		$users = GDO::table('GWF_User');
		$hidden = GWF_User::HIDE_ONLINE;
		$cutt = time() - $cut;
		$count = $users->countRows("user_lastactivity>$cutt AND user_options&$hidden=0");
		
		$href = GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1';
		$back .= sprintf('<div>%s</div>', $this->_module->lang('lp_last_online', array(GWF_Time::humanDuration($cut, 1))));
		$back .= sprintf('<ol><li>%s</li></ol>', $this->_module->lang('lp_last_online2', array($href, $count)));
		
		return $back;
	}
	
	private function leftPanelLanguage()
	{
		if (false === ($ml = GWF_Module::getModule('Language'))) {
			return '';
		}
		
		$back = '';
		
		$ml instanceof Module_Language;
		$back .= $ml->getSwitchLangSelect();
		
		return $back;
	}
	
}
?>
