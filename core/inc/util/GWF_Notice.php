<?php
/**
 * This class will get information about unread things for a User
 * ATM this class is trash but useable
 * @author spaceone
 * @todo WTF delete those fucking foo_bar_baz.php shit
 * @todo remove files and import here..
 * @todo this class could be usefull for Admin notifications
 * @todo import Heart_beat also?
 * @todo langfile
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

	public static function getUnreadLinks(GWF_User $user, $default='[0]')
	{
		if( false === self::loadModuleClass('Links', 'unread.php') )
		{
			return '';
		}
		return module_Links_unread($user, $default);
	}
	public static function getUnreadForum(GWF_User $user, $default='[0]')
	{
		if( false === self::loadModuleClass('Forum', 'unread.php') )
		{
			return '';
		}
		return module_Forum_unread($user, $default);
	}
	public static function getUnreadPM(GWF_User $user, $default='[0]')
	{
		if( false === self::loadModuleClass('PM', 'unread.php') )
		{
			return '';
		}
		return module_PM_unread($user, $default);
	}
	public static function getUnreadNews(GWF_User $user, $default='[0]')
	{
		if( false === self::loadModuleClass('News', 'unread.php') )
		{
			return '';
		}
		return module_News_unread($user, $default);
	}
	public static function getUnreadChallenges(GWF_User $user) { return ''; }
	public static function getUnreadPageBuilder(GWF_User $user) { return ''; }
	public static function getUnreadShoutbox(GWF_User $user) { return ''; }
	public static function getUnreadAudit(GWF_User $user) { return ''; }
	public static function getUnreadComments(GWF_User $user) { return ''; }
	public static function getUnread(GWF_User $user) { return ''; }

}
