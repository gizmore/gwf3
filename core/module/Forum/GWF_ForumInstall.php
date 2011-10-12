<?php
/** Install Forum.
 * @author gizmore
 */
final class GWF_ForumInstall
{
	public static function onInstall(Module_Forum $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'posts_per_thread' => array('10', 'int', '1', '255'),
			'threads_per_page' => array('20', 'int', '1', '255'),
			'num_latest_threads' => array('8', 'int', '0', '255'),
//			'num_latest_threads_pp' => array('20', 'int', '1', '255'),
		
			'max_title_len' => array('128', 'int', '16', '255'),
			'max_descr_len' => array('255', 'int', '16', '512'),
			'max_message_len' => array('16384', 'int', '16', '65535'),
			'max_sig_len' => array('512', 'int', '16', '1024'),
		
			'guest_posts' => array('YES', 'bool'),
			'guest_captcha' => array('YES', 'bool'),
			'mod_guest_time' => array('1 day', 'time', '0', GWF_Time::ONE_MONTH),
			'search' => array('YES', 'bool'),
//			'last_posts_reply' => array('9', 'int', '1', '50'),
			'mod_sender' => array(GWF_BOT_EMAIL, 'text', '4', GWF_User::EMAIL_LENGTH),
			'mod_receiver' => array(GWF_SUPPORT_EMAIL, 'text', '4', GWF_User::EMAIL_LENGTH),
			'unread' => array('YES', 'bool'),
			'gtranslate' => array('YES', 'bool'),
//			'subscr_sender' => array(GWF_BOT_EMAIL, 'text', '4', GWF_User::EMAIL_LENGTH),
//			'mail_microsleep' => array('200000', 'int', '1000', '5000000'),
			'thanks' => array('YES', 'bool'),
			'votes' => array('YES', 'bool'),
			'uploads' => array('YES', 'bool'),
			'watch_timeout' => array('300 seconds', 'time', '0', GWF_Time::ONE_HOUR),
			'postcount' => array('0', 'script'),
			'doublepost' => array('YES', 'bool'),
			'lang_boards' => array('NO', 'bool'),
		
			'post_timeout' => array('0', 'time', 0, '172800'),
		)).
		self::installForumDefaults($module);
	}
	
	private static function installForumDefaults(Module_Forum $module)
	{
		$back = '';
		
		$module->cachePostcount();
		
		# Install Root Board
		$back .= self::installRoot($module);
		
		# Install Moderator group
		if (false === GWF_Group::getByName('moderator'))
		{
			$moderator = new GWF_Group(array(
				'group_name' => 'moderator',
			));
			if (false === ($moderator->insert())) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		
		$back = '';
		if ($module->cfgLangBoards()) {
			$back = self::installLangBoards($module);
		}
		
		# Make Admins and Staff become Moderator
		return $back.self::installAdminToMod($module).self::installAttachments($module);
	}

	/**
	 * We install one root board per default. Return empty string on success or error msg.
	 * @param $forum
	 * @return string
	 */
	public static function installRoot(Module_Forum $forum)
	{
		$table = GDO::table('GWF_ForumBoard');
		
		# Do we have a root?
		if (false !== ($board = GWF_ForumBoard::getByID(1))) {
			return '';
		}

		$root = new GWF_ForumBoard(array(
			'board_bid' => 1,
			'board_pid' => 0,
			'board_gid' => 0,
			'board_pos' => 0,
			'board_options' => GWF_ForumBoard::GUEST_VIEW,
			'board_title' => GWF_SITENAME,
			'board_descr' => 'Forums',
			'board_postcount' => 0,
			'board_threadcount' => 0,
		));
		
		if (false === $root->insert()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return '';
	}
	
	private static function installLangBoards(Module_Forum $module)
	{
		if (false === ($lang_root = self::installLangBoardsRoot($module))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		$pid = $lang_root->getID();
		
		$back = '';
		$langs = GWF_Language::getSupportedLanguages();
		foreach ($langs as $lang)
		{
			$back .= self::createLangBoard($module, $lang, $pid);
		}
		return $back;
	}
	
	private static function installLangBoardsRoot(Module_Forum $module)
	{
		$iso = 'en';
		$title = $module->langISO($iso, 'lang_root_title');
		
		if (false !== ($lang_root = GWF_ForumBoard::getByTitle($title))) {
			return $lang_root;
		}
		
		$descr = $module->langISO($iso, 'lang_root_descr');
		$options = GWF_ForumBoard::GUEST_VIEW;
		if (false === ($lang_root = GWF_ForumBoard::createBoard($title, $descr, 1, $options, 0))) {
			return false;
		}
		
		return $lang_root;
	}
	
	private static function createLangBoard(Module_Forum $module, GWF_Language $lang, $parent)
	{
		$iso = $lang->getISO();
		$title = $module->langISO($iso, 'lang_board_title', array($lang->getVar('name')));

		if (false !== ($board = GWF_ForumBoard::getByTitle($title))) {
			return '';
		}
		
		$descr = $module->langISO($iso, 'lang_board_descr', array($lang->getVar('lang_nativename')));
		$options = GWF_ForumBoard::GUEST_VIEW|GWF_ForumBoard::ALLOW_THREADS;
		
		if (false === ($board = GWF_ForumBoard::createBoard($title, $descr, $parent, $options, 0))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return '';
	}
	
	private static function installAttachments(Module_Forum $module)
	{
		# Create dir
		$dirname = 'dbimg/forum_attach';
		if (is_dir($dirname) && is_readable($dirname)) {
		}
		elseif (false === @mkdir($dirname, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', $dirname);
		}
		
		# Protect it.
		if (false === GWF_HTAccess::protect($dirname)) {
			return GWF_HTML::err('ERR_WRITE_FILE', $dirname);
		}
		
		return '';
	}
	
	/**
	 * Make Admin and Staff moderators. return error message or empty string.
	 * @param Module_Forum $module
	 * @return string
	 */
	private static function installAdminToMod(Module_Forum $module)
	{
		$table = GDO::table('GWF_UserGroup');
		
		if (false === ($userids = $table->selectColumn('DISTINCT(ug_userid)', "group_name='staff' OR group_name='admin'", '', array('group')))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		foreach ($userids as $userid)
		{
			if (false === GWF_UserGroup::addToGroup($userid, 'moderator')) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		
		return '';
	}
	
}
?>