<?php
final class Lamb_HTML
{
	public static function menu()
	{
		$user = GWF_Session::getUser();
		$module = Module_Lamb::instance();
		return
			'<ul>'.
			self::menuNews($module, $user).
			self::menuShadowlamb($module, $user).
			self::menuForum($module, $user).
			self::menuPM($module, $user).
			self::menuSignup($module, $user).
			self::menuAdmin($module, $user).
			'</ul>'.PHP_EOL;
	}
	
	private static function menuNews(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'News' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'shadowlamb">'.$module->lang('menu_news').'</a></li>';
	}
	
	private static function menuShadowlamb(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Lamb' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'shadowlamb">'.$module->lang('menu_shadowlamb').'</a></li>';
	}
	
	private static function menuForum(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Forum' ? ' class="lamb_menu_sel"' : '';
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
	private static function getUnreadThreadCount($user)
	{
		$uid = $user->getVar('user_id');
		$threads = GWF_TABLE_PREFIX.'forumthread';
		$grp = GWF_TABLE_PREFIX.'usergroup';
		$permquery = "(thread_gid=0 OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=thread_gid))";
		$data = $user->getUserData();
		$stamp = isset($data['GWF_FORUM_STAMP']) ? $data['GWF_FORUM_STAMP'] : $user->getVar('user_regdate');
		$regtimequery = sprintf('thread_firstdate>=\'%s\'', $stamp);
		$query = "SELECT COUNT(*) FROM $threads WHERE (thread_postcount>0 AND ($permquery) AND ($regtimequery OR thread_force_unread LIKE '%:$uid:%') AND (thread_unread NOT LIKE '%:$uid:%') AND (thread_options&4=0))";
		$result = gdo_db()->queryFirst($query, false);
		return (int)$result[0];
	}

	private static function menuPM(Module_Lamb $module, $user)
	{
		if ($user === false) {
			return '';
		}
		$sel = Common::getGet('mo') === 'PM' ? ' class="lamb_menu_sel"' : '';
		$count = self::getUnreadPMCount($user);
		$app = $count === 0 ? '' : '['.$count.']';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'pm">'.$module->lang('menu_pm').$app.'</a></li>';
	}
	private static function getUnreadPMCount(GWF_User $user)
	{
		$db = gdo_db();
		$pms = GWF_TABLE_PREFIX.'pm';
		$uid = $user->getVar('user_id');
		$query = "SELECT COUNT(*) FROM $pms WHERE pm_to=$uid AND (pm_options&1=0)";
		$result = $db->queryFirst($query, false);
		return (int) $result[0];
	}
	
	private static function menuSignup(Module_Lamb $module, $user)
	{
		if ($user === false) {
			return
				self::menuRegister($module, $user).
				self::menuLogin($module, $user);
		}
		else {
			return
				self::menuAccount($module, $user).
				self::menuLogout($module, $user);
		}
	}
	
	private static function menuAccount(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Account' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'account">'.$module->lang('menu_account').'</a></li>';
	}
	
	private static function menuLogout(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Logout' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'logout">'.$module->lang('menu_logout', $user->displayUsername()).'</a></li>';
	}
	
	private static function menuLogin(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Login' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'login">'.$module->lang('menu_login').'</a></li>';
	}

	private static function menuRegister(Module_Lamb $module, $user)
	{
		$sel = Common::getGet('mo') === 'Register' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'register">'.$module->lang('menu_register').'</a></li>';
		
	}
	
	private static function menuAdmin(Module_Lamb $module, $user)
	{
		if ($user === false || (!$user->isInGroup('admin'))) {
			return '';
		}
		$sel = Common::getGet('mo') === 'Admin' ? ' class="lamb_menu_sel"' : '';
		return '<li><a'.$sel.' href="'.GWF_WEB_ROOT.'nanny">'.$module->lang('menu_admin').'</a></li>';
	}
	
}
?>