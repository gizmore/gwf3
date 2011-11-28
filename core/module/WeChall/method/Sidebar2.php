<?php
final class WeChall_Sidebar2 extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== ($state = Common::getGet('rightpanel'))) {
			GWF_Session::set('WC_RIGHT_PANEL', $state > 0);
			GWF_Website::redirectBack();
		}
	}
	
	public function displayShowButton(Module_WeChall $module)
	{
		return GWF_Button::add();
	}
	
	public function display(Module_WeChall $module)
	{
		$module->onInclude();
		return
			'<div id="wc_sidebar">'.PHP_EOL.
			$this->displayLogin($module).
			$this->displayStats($module).
			$this->displaySites($module).
			$this->displayTopTen($module).
			$this->displayActive($module).
			$this->displayOnline($module).
			'</div>'.PHP_EOL;
	}
	
	private function sidebox($title, $content='')
	{
		return
			'<div class="wc_side_box">'.PHP_EOL.
			'<div class="wc_side_title">'.$title.'</div>'.PHP_EOL.
			'<div class="wc_side_content">'.PHP_EOL.
				$content.PHP_EOL.
			'</div>'.PHP_EOL.
			'</div>'.PHP_EOL;
	}
	
	private function displayLogin(Module_WeChall $module)
	{
		if (GWF_Session::isLoggedIn()) {
			return '';
		}
		
		$formhash = '_username_password_bind_ip';
		$formhash = GWF_Password::getToken($formhash);
		$username = $module->lang('th_user_name');
		$password = $module->lang('th_password');
		$bind_ip = $module->lang('th_bind_ip');
		$register = $module->lang('menu_register');
		$forgot = $module->lang('btn_forgot_pw');
		$login = $module->lang('btn_login');
		
		$box = 
//			'<div id="sidebar_login">'.PHP_EOL.
			'<form action="'.GWF_WEB_ROOT.'login" method="post" id="wc_toplogin">'.PHP_EOL.
			'<div>'.GWF_CSRF::hiddenForm($formhash).'</div>'.PHP_EOL.
			'<div><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_user.gif" title="'.$username.'" alt="'.$username.':" />&nbsp;<input type="text" name="username" value="" /></div>'.PHP_EOL.
			'<div><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_pass.gif" title="'.$password.'" alt="'.$password.':" />&nbsp;<input type="password" name="password" value="" /></div>'.PHP_EOL.
			'<div class="le">'.$bind_ip.'&nbsp;<input type="checkbox" name="bind_ip" checked="checked" /></div>'.PHP_EOL.
			'<div class="le"><input type="submit" name="login" value="'.$login.'" /></div>'.PHP_EOL.
			'<div><a href="'.GWF_WEB_ROOT.'register">'.$register.'</a>&nbsp;&nbsp;&nbsp;<a href="'.GWF_WEB_ROOT.'recovery">'.$forgot.'</a></div>'.PHP_EOL.
//			GWF_Table::start().
//			'<tr><td><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_user.gif" title="'.$username.'" alt="'.$username.'" /></td><td><input type="text" name="username" value="" /></td></tr>'.PHP_EOL.
//			'<tr><td><img src="'.GWF_WEB_ROOT.'tpl/wc4/img/icon_pass.gif" title="'.$password.'" alt="'.$password.'" /></td><td><input type="password" name="password" value="" /></td></tr>'.PHP_EOL.
//			'<tr><td>'.$bind_ip.'</td><td><input type="checkbox" name="bind_ip" checked="checked" /></td></tr>'.PHP_EOL.
//			'<tr><td></td><td><input type="submit" name="login" value="'.$login.'" /></td></tr>'.PHP_EOL.
//			'<tr><td><a href="'.GWF_WEB_ROOT.'register">'.$register.'</a></td><td><a href="'.GWF_WEB_ROOT.'forgot">'.$forgot.'</a></td></tr>'.PHP_EOL.
//			GWF_Table::end().
			'</form>'.PHP_EOL;
//			'</div>'.PHP_EOL;
		return $this->sidebox($module->lang('ft_signup').$this->getHideButton($module), $box);
	}
	
	private function getHideButton(Module_WeChall $module)
	{
		return '<span class="">'.GWF_Button::delete($this->getMethodHref('&rightpanel=0'), $module->lang('btn_sidebar_on')).'</span>';
	}
	
	private function displayStats(Module_WeChall $module)
	{
		$db = gdo_db();
		$posts = GWF_TABLE_PREFIX.'forumpost';
		$postcount = $db->queryFirst("SELECT COUNT(*) c FROM $posts");
		$postcount = $postcount['c'];
		
		$btn = GWF_Session::isLoggedIn() ? $this->getHideButton($module) : '';

		$box = 
			'<div><a href="'.GWF_WEB_ROOT.'active_sites">'.$module->lang('rp_sitecount', array(count(WC_Site::getActiveSites()))).'</a></div>'.PHP_EOL.
			'<div><a href="'.GWF_WEB_ROOT.'challs">'.$module->lang('rp_challcount', array(GDO::table('WC_Challenge')->countRows())).'</a></div>'.PHP_EOL.
			'<div><a href="'.GWF_WEB_ROOT.'forum">'.$module->lang('rp_postcount', array($postcount)).'</a></div>'.PHP_EOL.
			'<div><a href="'.GWF_WEB_ROOT.'users">'.$module->lang('rp_usercount', array(GDO::table('GWF_User')->countRows())).'</a></div>'.PHP_EOL;
		return
			$this->sidebox($module->lang('rp_stats').$btn, $box);
	}
	
	private function displaySites(Module_WeChall $module)
	{
		$sites = array_reverse(WC_Site::getActiveSites());
		
		if (0 === ($count = count($sites))) {
			return '';
		}
		$box = '';
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			$box .= '<div>'.$site->displayLink().'</div>'.PHP_EOL;
		}
		return $this->sidebox($module->lang('rp_sites', array($count)), $box);
	}

	private function displayTopTen(Module_WeChall $module, $amount=10)
	{
		$users = GDO::table('GWF_User')->selectObjects('*', 'user_options&0x10000000=0', 'user_level DESC', $amount);
		if (count($users) === 0) {
			return '';
		}
		$box = '';
		foreach ($users as $user)
		{
			$box .= sprintf('<div><a href="%s" title="%s">%s</a></div>', $user->getProfileHREF(), $module->lang('a_title', array($user->getVar('user_level'))), $user->displayUsername()).PHP_EOL;
		}
		return $this->sidebox($module->lang('rp_topusers', array($amount)), $box);
	}
	
	private function displayActive(Module_WeChall $module, $amount=20)
	{
		$db = gdo_db();
		$amount = (int) $amount;
		$u = GWF_TABLE_PREFIX.'user';
		$r = GWF_TABLE_PREFIX.'wc_regat';
		$s = GWF_TABLE_PREFIX.'wc_site';
		$query = "SELECT user_id, user_name, user_level, regat_solved, site_name FROM $r LEFT JOIN $u ON user_id=regat_uid LEFT JOIN $s ON site_id=regat_sid ORDER BY regat_lastdate DESC LIMIT $amount";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}

		$box = '';
		while (false !== ($row = $db->fetchRow($result)))
		{
			$href = GWF_WEB_ROOT.'profile/'.urlencode($row[1]);
			$title = $module->lang('li_last_active', array(GWF_HTML::display($row[1]), round($row[3]*100, 2), GWF_HTML::display($row[4])));
			$box .= sprintf('<div><a href="%s" title="%s">%s</a></div>', $href, $title, GWF_HTML::display($row[1]));
		}
		
		return $this->sidebox($module->lang('rp_last_active', array($amount)), $box);
	}
	
	private function displayOnline(Module_WeChall $module, $max=20)
	{
		$cut = $module->cfgLastActiveTime();
		$users = GDO::table('GWF_User');
		$hidden = GWF_User::HIDE_ONLINE;
		$deleted = GWF_User::DELETED;
		$cutt = time() - $cut;
		$conditions = "user_lastactivity>$cutt AND user_options&$hidden=0 AND user_options&$deleted=0";
		$count = $users->countRows($conditions);
		$href = GWF_WEB_ROOT.'users/with/All/by/user_lastactivity/DESC/page-1';
		
		$box = sprintf('<div>%s</div>', $module->lang('lp_last_online2', array($href, $count)));
		
		$users2 = $users->selectObjects('*', $conditions, 'user_lastactivity DESC', $max);
		foreach ($users2 as $user)
		{
			$user instanceof GWF_User;
			$box .= '<div>'.$user->displayProfileLink().'</div>';
		}
		
		if ($count > $max) {
			$box .= '<div><a href="'.$href.'">more...</a></div>';
		}
		
		return $this->sidebox($module->lang('lp_last_online', array(GWF_Time::humanDuration($cut, 1))), $box);
	}
	
}
?>