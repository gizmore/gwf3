<?php
final class BAIM
{
	public static function displayMenu()
	{
		$module = Module_BAIM::getInstance();
		
		return
			'<div id="baimmenu">'.
			self::menuNews($module).
			self::menuDownload($module).
			self::menuLinks($module).
			self::menuGuestbook($module).
			self::menuForum($module).
			self::menuChat($module).
			self::menuPM($module).
			self::menuSignup($module).
			'</div>';
	}
	
	private static function menuNews(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'News';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'news';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_news'));
	}
	
	private static function menuDownload(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Download';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'downloads';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_dl'));
	}
	
	private static function menuLinks(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Links';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'links';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_links'));
	}
	
	private static function menuGuestbook(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Guestbook';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'guestbook';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_gb'));
	}

	private static function menuSignup(Module_BAIM $module)
	{
		$back = '';
		if (false === ($user = GWF_Session::getUser()))
		{
			$back .= self::menuRegister($module).self::menuLogin($module);
		}
		else
		{
			$back .= self::menuAccount($module);
			$back .= self::menuLogout($module);
			if ($user->isAdmin()) {
				$back .= self::menuAdmin($module);
			}
		}
		return $back;
	}
	
	private static function menuRegister(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Register';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'register';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_register'));
	}
	
	private static function menuLogin(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Login';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'login';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_login'));
	}

	private static function menuLogout(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Logout';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'logout';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_logout'));
	}

	private static function menuAdmin(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Download';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'nanny';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_admin'));
	}
	
	private static function menuForum(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Forum';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'forum';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_forum').self::menuForumAppend($module));
	}
	
	private static function menuForumAppend(Module_BAIM $module)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return '';
		}
		$uid = $user->getVar('user_id');
		$threads = GWF_TABLE_PREFIX.'forumthread';
		$grp = GWF_TABLE_PREFIX.'usergroup';
		$permquery = "(thread_gid=0 OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=thread_gid))";
		$data = $user->getUserData();
		$stamp = isset($data['GWF_FORUM_STAMP']) ? $data['GWF_FORUM_STAMP'] : $user->getVar('user_regdate');
		$regtimequery = sprintf('thread_lastdate>=\'%s\'', $stamp);
		$query = "SELECT COUNT(*) c FROM $threads WHERE (thread_postcount>0 AND ($permquery) AND ($regtimequery OR thread_force_unread LIKE '%:$uid:%') AND (thread_unread NOT LIKE '%:$uid:%') AND (thread_options&4=0))";
		$result = gdo_db()->queryFirst($query);
		if ($result['c'] === '0') {
			return '';
		}
		return '['.$result['c'].']';
	}

	private static function menuChat(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Chat';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'irc_chat';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_chat'));
	}
	
	private static function menuPM(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'PM';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'pm';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_pm').self::menuPMAppend($module));
	}
	
	private static function menuPMAppend(Module_BAIM $module)
	{
		if ('0' === ($uid = GWF_Session::getUserID())) {
			return '';
		}
		$db = gdo_db();
		$pms = GWF_TABLE_PREFIX.'pm';
		$query = "SELECT COUNT(*) c FROM $pms WHERE pm_owner=$uid AND pm_to=$uid AND (pm_options&1=0)";
		$result = $db->queryFirst($query);
		if ($result['c'] === '0') {
			return '';
		}
		return '['.$result['c'].']';
	}
	
	private static function menuAccount(Module_BAIM $module)
	{
		$sel = Common::getGet('mo') === 'Account';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'account';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_account'));
	}
	
	public static function accountButtons()
	{
		$module = Module_BAIM::getInstance();
		return
			'<div class="gwf_buttons_outer gwf_buttons">'.PHP_EOL.
			GWF_Button::generic($module->lang('menu_account'), GWF_WEB_ROOT.'account', 'generic', '', Common::getGet('mo') === 'Account').
			GWF_Button::generic($module->lang('menu_profile'), GWF_WEB_ROOT.'profile_settings', 'generic', '', Common::getGet('mo') === 'Profile').
			GWF_Button::generic($module->lang('menu_mc'), GWF_WEB_ROOT.'index.php?mo=BAIM&me=SetMC', 'generic', '', Common::getGet('mo') === 'BAIM').
			'</div>'.PHP_EOL;
	}
}
?>