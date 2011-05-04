<?php
final class PT_Menu
{
	public static function display()
	{
		$module = Module_PoolTool::getInstance();
			
		return
			'<div id="ptmenu">'.
			self::displayMiniMenu($module).
			self::displayMenuLang($module).
			self::displayMenuNews($module).
			self::displayMenuAbout($module).
			self::displayMenuTutorial($module).
			self::displayMenuDownload($module).
			self::displayMenuLogo($module).
			self::displayMenuChat($module).
			self::displayMenuForum($module).
			self::displayMenuPM($module).
			self::displayMenuGuestbook($module).
			self::displayMenuContact($module).
			self::displayMenuLinks($module).
			self::displayMenuLang2($module).
//			self::displayMenuAdmin($module).
//			self::displayMenuSignup($module).
			'</div>';
	}
	
	public static function accountButtons()
	{
		$l = GWF_Module::getModule('PoolTool')->getLanguage();
		return
			GWF_Button::wrapStart().
			GWF_Button::generic($l->lang('menu_profile'), GWF_WEB_ROOT.'profile_settings').
			GWF_Button::wrapEnd();
	}
	
	private static function displayMenuLang2(Module_PoolTool $module)
	{
//		return GWF_Website::getSwitchLangSelectDomain();
	}
	
	private static function displayMenuLang(Module_PoolTool $module)
	{
		switch (GWF_Language::getCurrentISO())
		{
			case 'de':
				$country = GWF_Country::getByTLD('gb');
				$to = 'en';
				break;
			case 'en':
			default:
				$country = GWF_Country::getByTLD('de');
				$to = 'de';
				break;
		}
		$href = sprintf('http://%s.%s%s', $to, GWF_DOMAIN, htmlspecialchars($_SERVER['REQUEST_URI']));
		return sprintf('<a href="%s">%s</a>', $href, $country->displayFlag());
	}
	
	private static function displayMenuNews(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'News';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'news';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_news'));
		
	}

	private static function displayMenuAbout(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'PoolTool' && Common::getGet('me') === 'About';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'about_pooltool';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_about'));
		
	}
	
	private static function displayMenuDownload(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Download';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'downloads';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_dl'));
		
	}

	private static function displayMenuTutorial(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'PoolTool' && Common::getGet('me') === 'Tutorial';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'pooltool_tutorial';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_tut'));
	}

	private static function displayMenuLogo(Module_PoolTool $module)
	{
		return sprintf('<a href="%s"><img src="%s" alt="Pooltool Logo"/></a>', GWF_WEB_ROOT.'about_pooltool', GWF_WEB_ROOT.'tpl/pt/img/banner.gif');
	}

	private static function displayMenuChat(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Chat';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'irc_chat';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_chat'));
	}
	
	private static function displayMenuForum(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Forum';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'forum';
		
		$app = '';
		if (false !== ($user = GWF_Session::getUser()))
		{
			require_once 'module/Forum/GWF_ForumThread.php';
			$count = GWF_ForumThread::getUnreadThreadCount($user);
			if ($count > 0) {
				$app = " [$count]";
			}
		}
		
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_forum').$app);
	}
	
	private static function displayMenuPM(Module_PoolTool $module)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return '';
		}
		$sel = Common::getGet('mo') === 'PM';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'pm';
		
		$count = self::getUnreadPMCount($user);
		$app = $count === '0' ? '' : " [$count]";
		
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_pm').$app);
	}
	private static function getUnreadPMCount(GWF_User $user)
	{
		$db = gdo_db();
		$pms = GWF_TABLE_PREFIX.'pm';
		$uid = $user->getVar('user_id');
		$query = "SELECT COUNT(*) c FROM $pms WHERE pm_owner=$uid AND (pm_options&1=0)";
		$result = $db->queryFirst($query, false);
		return $result['c'];
	}
	
	private static function displayMenuGuestbook(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Guestbook';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'guestbook';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_gb'));
	}

	private static function displayMenuContact(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Contact';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'contact';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_contact'));
	}

	private static function displayMenuLinks(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Links';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'links';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_links'));
	}
	
	private static function displayMiniMenu(Module_PoolTool $module)
	{
		$back = '<div id="ptminimenu">';
		$user = GWF_Session::getUser();
		if ($user !== false && !$user->isWebspider())
		{
			$back .= self::displayMenuAccount($module);
			$back .= self::displayMenuLogout($module);
			$back .= self::displayMenuAdmin($module);
			$back .= self::displayMenuHelpdesk($module);
		}
		else
		{
			$back .= self::displayMenuLogin($module);
			$back .= self::displayMenuRegister($module);
			if ($user !== false && $user->isWebspider()) {
				$back .= self::displayMenuLogout($module);
			}
		}
		$back .= '</div>';
		return $back;
	}

	private static function displayMenuAccount(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Account';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'account';
		$uname = GWF_Session::getUser()->displayUsername();
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_account')."[$uname]");
	}
	
	private static function displayMenuAdmin(Module_PoolTool $module)
	{
		if (!GWF_User::isAdminS()) {
			return '';
		}
		$sel = Common::getGet('mo') === 'Admin';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'nanny';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_admin'));
	}

	private static function displayMenuHelpdesk(Module_PoolTool $module)
	{
		$sel = Common::getGetString('mo') === 'Helpdesk' ? ' class="menu_sel"' : ''; 
		$append = self::helpdeskAppend();
		return sprintf('<a %shref="%s">%s</a>', $sel, GWF_WEB_ROOT.'helpdesk', $module->lang('menu_helpdesk').$append);
	}
	
	private static function helpdeskAppend()
	{
		$db = gdo_db();
		$tickets = GWF_TABLE_PREFIX.'helpdesk_ticket';
		$uid = GWF_Session::getUserID();
		$query = "SELECT COUNT(*) c FROM $tickets WHERE hdt_uid=$uid AND (hdt_options&2=0)";
		$result = $db->queryFirst($query);
		if ($result['c'] < 1) {
			return '';
		}
		return '['.$result['c'].']';
	}

	private static function displayMenuLogout(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Logout';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'logout';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_logout'));
	}
	
	private static function displayMenuLogin(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Login';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'login';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_login'));
	}
	
	private static function displayMenuRegister(Module_PoolTool $module)
	{
		$sel = Common::getGet('mo') === 'Register';
		$sel = $sel ? ' class="menu_sel"' : ''; 
		$href = GWF_WEB_ROOT.'register';
		return sprintf('<a %shref="%s">%s</a>', $sel, $href, $module->lang('menu_register'));
	}
}
?>