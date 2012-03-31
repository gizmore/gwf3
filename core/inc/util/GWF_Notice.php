<?php
/**
 * This class will get information about unread things for a User
 * ATM this class is trash but useable
 * @author spaceone
 * @todo this class could be usefull for Admin notifications
 * @todo langfile
 * @todo rename (GWF_Notifications ?)
 */
final class GWF_Notice
{
	public static function loadModuleClass($module, $file)
	{
		$path = GWF_CORE_PATH.'module/'.$module.'/'.$file;
		if(false === Common::isFile($path))
		{
			return false;
		}
		require_once $path;
	}

	public static function getUnreadLinks(GWF_User $user, $pattern='[%s]', $default='[0]')
	{
		if( false === self::loadModuleClass('Links', 'GWF_Links.php') )
		{
			return '';
		}

		if (false === $user->isGuest())
		{
			$links = GWF_Module::loadModuleDB('Links');
			$links instanceof Module_Links;

			if (0 < ((int)$unread = $links->countUnread($user)))
			{
				return sprintf($pattern, $unread);
			}
			return $default;
		}
		return '';
	}

	/**
	 * Get Forum Unread Counter - Quickhook for topmenu.
	 * @param array(GWF_User $user)
	 * @return string the counter enclosed in [counter]
	 * @todo create countUnread()
	 */
	public static function getUnreadForum(GWF_User $user, $pattern='[%s]', $default='[0]')
	{
		if( false === self::loadModuleClass('Forum', 'GWF_ForumThread.php') )
		{
			return '';
		}

		if ((true === $user->isGuest()) || (true === $user->isWebspider()))
		{
			return '';
		}

		$uid = $user->getID();
		$data = $user->getUserData();
		$grp = GWF_TABLE_PREFIX.'usergroup';
		$permquery = "(thread_gid=0 OR (SELECT 1 FROM {$grp} WHERE ug_userid={$uid} AND ug_groupid=thread_gid))";
		$stamp = isset($data['GWF_FORUM_STAMP']) ? $data['GWF_FORUM_STAMP'] : $user->getVar('user_regdate');
		$regtimequery = sprintf('thread_lastdate>=\'%s\'', $stamp);
		$conditions = "( (thread_postcount>0) AND ({$permquery}) AND ({$regtimequery} OR thread_force_unread LIKE '%:{$uid}:%') AND (thread_unread NOT LIKE '%:{$uid}:%') AND (thread_options&4=0) )";
		if (false === ($count = GDO::table('GWF_ForumThread')->selectVar('COUNT(*)', $conditions)))
		{
			return ''; # DB Error
		}
		return $count === '0' ? $default : sprintf($pattern, $count);
	}

	/**
	 * @todo create countUnread()
	 * @param GWF_User $user
	 * @param string $pattern
	 * @param string $default
	 * @return String
	 */
	public static function getUnreadPM(GWF_User $user, $pattern='[%s]', $default='[0]')
	{
		if( false === self::loadModuleClass('PM', 'GWF_PM.php') )
		{
			return '';
		}
		if (false === $user->isGuest())
		{
			$read = GWF_PM::READ;
			$userid = $user->getID();
			$count = GDO::table('GWF_PM')->countRows("pm_owner={$userid} AND pm_to={$userid} AND pm_options&{$read}=0");
			if ((int)$count > 0)
			{
				return sprintf($pattern, $count);
			}
		}
		return '';
	}

	public static function getUnreadNews(GWF_User $user, $pattern='[%s]', $default='[0]')
	{
		return ''; # doesnt exists ATM
	}

	public static function getUnreadChallenges(GWF_User $user) { return ''; }
	public static function getUnreadPageBuilder(GWF_User $user) { return ''; }
	public static function getUnreadShoutbox(GWF_User $user) { return ''; }
	public static function getUnreadAudit(GWF_User $user) { return ''; }
	public static function getUnreadComments(GWF_User $user) { return ''; }
//	public static function getUnread(GWF_User $user) { return ''; } # Template

	public static function getOnlineUsers($pattern='<span id="gwf_heartbeat">%s</span>', $default='0')
	{
		if (false !== ($heart = GWF_Module::loadModuleDB('Heart', false, false, true)))
		{
			return sprintf($pattern, $heart->execute('Beat'));
		}
		return $default;
	}

}
