<?php
/**
 * My forum. Attemp 2 :)
 * @author gizmore
 */
final class Module_Forum extends GWF_Module
{
	################
	### Instance ###
	################
	/**
	 * @return Module_Forum
	 */
	public static function getInstance()
	{
		static $instance = true;
		if ($instance === true)
		{
			$instance = GWF_Module::getModule('Forum');
		}
		return $instance; 
	}
	
	############
	### Vars ###
	############
	private $unread_threads = 0;
	public function getUnreadThreadCount() { return $this->unread_threads; }
	
	###########################
	### Shared Request Vars ###
	###########################
	private $board_id = 0;
	private $thread_id = 0;
	private $post_id = 0;
	/**
	 * @var GWF_ForumBoard
	 */
	private $board = false;
	/**
	 * @var GWF_ForumThread
	 */
	private $thread = false;
	/**
	 * @var GWF_ForumPost
	 */
	private $post = false;
	public function getBoardID() { return $this->board->getID(); }
	public function getThreadID() { return $this->thread->getID(); }
	public function getPostID() { return $this->post->getID(); }
	
	public function setCurrentBoard(GWF_ForumBoard $board) { $this->board = $board; $this->board_id = $_GET['bid'] = $board->getID(); }

	/**
	 * @return GWF_ForumBoard
	 */
	public function getCurrentBoard() { return $this->board; }
	/**
	 * @return GWF_ForumThread
	 */
	public function getCurrentThread() { return $this->thread; }
	/**
	 * @return GWF_ForumPost
	 */
	public function getCurrentPost() { return $this->post; }
	
	##############
	### Module ###
	##############
	public function getVersion() { return 1.07; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/forum'); }
	public function getAdminSectionURL() { return GWF_WEB_ROOT.'forum/admin'; }
	public function onCronjob() { require_once 'GWF_ForumCronjob.php'; return GWF_ForumCronjob::onCronjob($this); }
	public function onInstall($dropTable) { require_once 'GWF_ForumInstall.php'; return GWF_ForumInstall::onInstall($this, $dropTable); }
	public function onMerge(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar) { require_once 'Merge_Forum.php'; return Merge_Forum::onMerge($db_from, $db_to, $db_offsets, $prefix, $prevar); }
	
	public function getClasses()
	{
		return array(
			'GWF_ForumAttachment',
			'GWF_ForumBoard',
			'GWF_ForumOptions',
			'GWF_ForumPost',
			'GWF_ForumPostHistory',
			'GWF_ForumSubscrBoard',
			'GWF_ForumSubscription',
			'GWF_ForumThread',
			'GWF_ForumVisitors',
		);
	}
	
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::CHANGE_UNAME, array(__CLASS__, 'hookRenameUser'));
		GWF_Hook::add(GWF_Hook::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
		GWF_Hook::add(GWF_Hook::ADD_TO_GROUP, array(__CLASS__, 'hookAddToGroup'));
	}
	
//	public function onAddMenu()
//	{
//		$append = '';
//		if (false !== ($user = GWF_Session::getUser()))
//		{
//			require_once 'GWF_ForumThread.php';
//			$this->unread_threads = $c = GWF_ForumThread::getUnreadThreadCount($user);
//			if ($c > 0) {
//				$append = sprintf('[%d]', $c);
//			}
//		}
//		
//		GWF_TopMenu::addMenu('forum', GWF_WEB_ROOT.'forum', $append, $this->isSelected());
//	}
	
	#############
	### Hooks ###
	#############
	public function hookRenameUser(GWF_User $user, array $args)
	{
		$this->onInclude();
		GWF_ForumThread::hookRenameUser($user, $args[0]);
		GWF_ForumPost::hookRenameUser($user, $args[0]);
	}
	
	public function hookDeleteUser(GWF_User $user, array $args)
	{
		$this->onInclude();
		GWF_ForumThread::hookDeleteUser($user);
		GWF_ForumPost::hookDeleteUser($user);
	}
	
	public function hookAddToGroup(GWF_User $user, array $args)
	{
		list($gid, $groupname) = $args;
		$this->onInclude();
		GWF_ForumThread::hookAddToGroup($user, $gid);
	}
	
	##############
	### Config ###
	##############
	public function getPostsPerThread() { return $this->getModuleVarInt('posts_per_thread', 10); }
	public function getThreadsPerPage() { return $this->getModuleVarInt('threads_per_page', 20); }
	public function getNumLatestThreads() { return $this->getModuleVarInt('num_latest_threads', 8); }
//	public function getNumLatestThreadsPP() { return $this->getModuleVarInt('num_latest_threads_pp', 20); }
	public function getMaxTitleLen() { return $this->getModuleVarInt('max_title_len', 128); }
	public function getMaxDescrLen() { return $this->getModuleVarInt('max_descr_len', 255); }
	public function getMaxMessageLen() { return $this->getModuleVarInt('max_message_len', 16384); }
	public function getMaxSignatureLen() { return $this->getModuleVarInt('max_sig_len', 512); }
	public function isGuestPostAllowed() { return $this->getModuleVarBool('guest_posts', '1'); }
	public function isGuestPostModerated() { return true; }# $this->getModerationTime() > 0; }
//	public function getModerationTime() { return $this->getModuleVarInt('mod_guest_time', GWF_Time::ONE_DAY); }
	public function isSearchAllowed() { return $this->getModuleVarBool('search', '1'); }
	public function getNumLastPostsForReply() { return $this->getPostsPerThread() - 1; }
	public function getModerationSender() { return $this->getModuleVar('mod_sender', GWF_BOT_EMAIL); }
	public function getModerationReceiver() { return $this->getModuleVar('mod_receiver', GWF_SUPPORT_EMAIL); }
	public function isUnreadThreadsEnabled() { return $this->getModuleVarBool('unread', '1'); }
	public function cfgUseGTranslate() { return $this->getModuleVarBool('gtranslate', '1'); }
//	public function getSubscriptionSender() { return $this->getModuleVar('subscr_sender', GWF_BOT_EMAIL); }
	public function cfgMailMicrosleep() { return 200000; }
	public function cfgThanksEnabled() { return $this->getModuleVarBool('thanks', '1'); }
	public function cfgVotesEnabled() { return $this->getModuleVarBool('votes', '1'); }
	public function cfgWatchTimeout() { return $this->getModuleVar('watch_timeout', 300); }
	public function cfgPostCount() { return $this->getModuleVarInt('postcount', 0); }
	public function cfgDoublePost() { return $this->getModuleVarBool('doublepost', '1'); }
	public function cfgLangBoards() { return $this->getModuleVarBool('lang_boards', '0'); }
	public function cfgGuestCaptcha() { return $this->getModuleVarBool('guest_captcha'); }
	public function cfgPostTimeout() { return $this->getModuleVar('post_timeout'); }
	public function cfgPostMinLevel() { return $this->getModuleVar('post_min_level'); }
	public function cfgOldURLS() { return $this->getModuleVarBool('gwf2_rewrites', false); }
	
	##################
	### On Request ###
	##################
	public function onRequestInit()
	{
		GWF_ForumBoard::init();
		
		# Init by Post
		if (0 !== ($this->post_id = (int)Common::getGet('pid', 0))) {
			if (false === ($this->post = GWF_ForumPost::getPost($this->post_id))) {
				$this->post_id = 0;
			}
			elseif (false !== ($this->thread = $this->post->getThread())) {
				$this->thread_id = $this->thread->getID();
				if (false !== ($this->board = $this->thread->getBoard())) {
					$this->board_id = $this->board->getID();
				}
			} 
		}
		
		# Init by Thread
		elseif (0 !== ($this->thread_id = (int) Common::getGet('tid', 0))) {
			if (false === ($this->thread = GWF_ForumThread::getThread($this->thread_id))) {
				$this->thread_id = 0;
			}
			elseif (false !== ($this->board = $this->thread->getBoard())) {
				$this->board_id = $this->board->getID();
			}
		}
		
		# Init by Board
		else
		{
			$this->board_id = Common::getGetString('bid', '1');
			if (false === ($this->board = GWF_ForumBoard::getBoard($this->board_id)))
			{
				$this->board_id = '1';
				if (false === ($this->board = GWF_ForumBoard::getRoot()))
				{	
					$this->board_id = '0';
				}
			}
		}
		
		if (($this->thread_id !== 0) && (0 < ($cut = $this->cfgWatchTimeout()))) {
			GWF_ForumVisitors::setWatching($this->thread, $cut);
		}
	}
	
	public function execute($methodname)
	{
		$this->onRequestInit();
		$back = parent::execute($methodname);
		return $back;
	}
	
	###############
	### Selects ###
	###############
	public function getGroupSelect($selected='0', $name='groupid')
	{
		return GWF_GroupSelect::single($name, $selected, true, false);
	}
	
	##################
	### Validators ###
	##################
	public function validate_parentid($arg)
	{
		if (false === ($board = GWF_ForumBoard::getBoard($arg))) {
			return $this->lang('err_parentid');
		}
		return false;
	}
	
	public function validate_groupid($arg)
	{
		$arg = (int) $arg;
		if ($arg === 0) {
			return false;
		}
		if (false === ($group = GWF_Group::getByID($arg))) {
			return $this->lang('err_groupid');
		}
		return false;
	}
	
	public function validate_title($arg)
	{
		$arg = trim($arg);
		$_POST['title'] = $arg;
		$len = strlen($arg);
		if ($len < 3) {
			return $this->lang('err_title_short');
		} else if ($len > $this->getMaxTitleLen()) {
			return $this->lang('err_title_long', $this->getMaxTitleLen());
		}else {
			return false;
		}
	}
	
	public function validate_descr($arg)
	{
		$arg = trim($arg);
		$_POST['descr'] = $arg;
		$len = strlen($arg);
		if ($len < 0) {
			return $this->lang('err_descr_short');
		} else if ($len > $this->getMaxDescrLen()) {
			return $this->lang('err_descr_long', $this->getMaxDescrLen());
		}else {
			return false;
		}
	}

	public function validate_message($arg)
	{
		$arg = trim($arg);
		$_POST['message'] = $arg;
		$len = strlen($arg);
		if ($len < 3) {
			return $this->lang('err_msg_short');
		} else if ($len > $this->getMaxMessageLen()) {
			return $this->lang('err_msg_long', $this->getMaxMessageLen());
		}else {
			return false;
		}
	}

	public function validate_signature($arg)
	{
		$arg = trim($arg);
		$_POST['signature'] = $arg;
		$len = strlen($arg);
		if ($len < 0) {
			return $this->lang('err_sig_short');
		} else if ($len > $this->getMaxSignatureLen()) {
			return $this->lang('err_sig_long', $this->getMaxSignatureLen());
		}else {
			return false;
		}
	}
	
	public function validate_thread($arg)
	{
		if (false === (GWF_ForumThread::getThread($arg))) {
			return $this->lang('err_thread');
		}
		return false;
	}
	
	##################
	### Permission ###
	##################
	/**
	 * Check if user can add a thread in current board.
	 * Returns error message or false on success.
	 * @return string or false
	 */
	public function isNewThreadAllowed()
	{
		if (false !== ($error = $this->isPostTimeout())) {
			return $error;
		}
		
		if (false === ($board = $this->getCurrentBoard())) {
			return $this->error('err_board');
		}

		if ($board->isLocked()) {
			return $this->error('err_board_locked');
		}
		
		if (!$board->isThreadAllowed()) {
			return $this->error('err_no_thread_allowed');
		}
		
		if (!$board->hasPermissionS()) {
			return $this->error('err_board_perm');
		}
		
		$user = GWF_Session::getUser();
		
		# Logged in?
		if ($user !== false)
		{
			# Level
			if ($user->getLevel() < $this->cfgPostMinLevel())
			{
				return $this->error('err_post_level', array($this->cfgPostMinLevel()));
			}
			elseif ($user->isWebspider())
			{
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
			else
			{
				return false;
			}
		}

		# Guest Below here
		if (!$this->isGuestPostAllowed()) {
			return $this->error('err_no_guest_post');
		}
		
		if (!$board->isGuestPostAllowed()) {
			return $this->error('err_no_guest_post');
		}
		
		return false;
	}
	
	private function isPostTimeout()
	{
		if (0 == ($timeout = $this->cfgPostTimeout()))
		{
			return false; # No limit 
		}
		$user = GWF_Session::getUser();
		if (0 === ($lastpost = $this->getLastPostTime($user)))
		{
			return false; # No posts yet
		}
		
		$elapsed = time() - $lastpost;
		if ($elapsed >= $timeout)
		{
			return false; # In limit
		}
		
		$wait = $timeout - $elapsed;
		return $this->error('err_post_timeout', array(GWF_Time::humanDuration($wait)));
	}
	
	private function getLastPostTime($user)
	{
		if (false === ($result = GDO::table('GWF_ForumPost')->selectVar('MAX(post_date)')))
		{
			return 0;
		}
		return GWF_Time::getTimestamp($result);
	}
	
	############################
	### Convinent Forum Tree ###
	############################
	public static function getNavTree($imploder='->')
	{
		$module = self::getInstance();
		if (false === ($board = $module->getCurrentBoard()))
		{
			return '';
		}

		$back = array();
		$tree = $board->getBoardTree();
		foreach ($tree as $b)
		{
			list($reserved, $bid, $title) = $b;
			$back[] = GWF_HTML::anchor(GWF_WEB_ROOT."forum-b$bid/".Common::urlencodeSEO($title).'.html', $title);
		}
		return implode($imploder, $back);
	}
	
	#######################
	### Cache Postcount ###
	#######################
	/**
	 * Fix some post counters.
	 */
	public function cachePostcount()
	{
		$mod = GWF_ForumPost::IN_MODERATION;
		$this->saveModuleVar('postcount', GDO::table('GWF_ForumPost')->countRows("post_options&$mod=0"));
		$posts = GWF_TABLE_PREFIX.'forumpost';
		return GDO::table('GWF_ForumOptions')->update("fopt_posts=(SELECT COUNT(*) FROM $posts WHERE post_uid=fopt_uid AND post_options&$mod=0)");
	}
	
	
}

?>
