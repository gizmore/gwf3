<?php

final class GWF_ForumThread extends GDO
{
	###################
	### Option Bits ###
	###################
	const STICKY = 0x01;
	const CLOSED = 0x02;
	const IN_MODERATION = 0x04;
	const HIDDEN = 0x08;
	const GUEST_VIEW = 0x10;
	const INVISIBLE = 0x20;
	
	const STAMP_NAME = 'GWF_FORUM_STAMP';
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumthread'; }
	public function getOptionsName() { return 'thread_options'; }
	public function getColumnDefines()
	{
		return array(
			'thread_tid' => array(GDO::AUTO_INCREMENT),
			'thread_bid' => array(GDO::UINT|GDO::INDEX, 0),
			'thread_gid' => array(GDO::UINT|GDO::INDEX, 0),
			'thread_uid' => array(GDO::UINT|GDO::INDEX, 0),

			'thread_firstposter' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, true, GWF_User::USERNAME_LENGTH),
			'thread_firstdate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, '19701231235959', GWF_Date::LEN_SECOND),

			'thread_lastpost' => array(GDO::UINT, 0),
			'thread_lastposter' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, true, GWF_User::USERNAME_LENGTH),
			'thread_lastdate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, '19701231235959', GWF_Date::LEN_SECOND),

			'thread_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'thread_options' => array(GDO::UINT|GDO::INDEX, 0),
			'thread_postcount' => array(GDO::UINT|GDO::INDEX, 0),
			'thread_viewcount' => array(GDO::UINT, 0),
			'thread_watchers' => array(GDO::UINT, 0),

			'thread_thanks' => array(GDO::UINT, 0),
			'thread_votes_up' => array(GDO::UINT, 0),
			'thread_votes_down' => array(GDO::UINT, 0),

			'thread_unread' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),

			'thread_pollid' => array(GDO::UINT, 0), # GWF_VoteMulti
		
			'thread_force_unread' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
		);
	}

	###################
	### Convinience ###
	###################
	public function getPostCount() { return $this->getVar('thread_postcount'); }
	public function getGroupID() { return $this->getVar('thread_gid'); }
	public function getBoardID() { return $this->getVar('thread_bid'); }
	public function getID() { return $this->getVar('thread_tid'); }
	public function isSticky() { return $this->isOptionEnabled(self::STICKY); }
	public function isHidden() { return $this->isOptionEnabled(self::HIDDEN); }
	public function isClosed() { return $this->isOptionEnabled(self::CLOSED); }
	public function isInModeration() { return $this->isOptionEnabled(self::IN_MODERATION); }
	public function isGuestView() { return $this->isOptionEnabled(self::GUEST_VIEW); }
	public function getToken() { return GWF_Password::getToken($this->getVar('thread_title').$this->getVar('thread_lastdate')); }
	public function displayFirstDate() { return GWF_Time::displayDate($this->getVar('thread_firstdate')); }
	public function displayLastDate() { return GWF_Time::displayDate($this->getVar('thread_lastdate')); }
	public function displayBoardTitle() { return $this->getBoard()->display('board_title'); }
	public function hasPoll() { return $this->getPollID() !== '0'; }
	public function getPollID() { return $this->getVar('thread_pollid', '0'); }
	public function getPoll() { return GWF_VoteMulti::getByID($this->getPollID()); }
	
	public function setVisible($visible=true) { return $this->saveOption(self::INVISIBLE, !$visible); }
	public function isInvisible() { return $this->isOptionEnabled(self::INVISIBLE); }

	public function markUnRead($lastposterid) { $this->saveVar('thread_unread', ':'.intval($lastposterid).':'); }

	/**
	 * @return GWF_ForumBoard
	 */
	public function getBoard() { return GWF_ForumBoard::getBoard($this->getBoardID()); }

	######################
	### Static Getters ###
	######################
	/**
	 * Get a thread by ID.
	 * @param int $thread_id
	 * @return GWF_ForumThread
	 */
	public static function getByID($thread_id)
	{
		return self::table(__CLASS__)->getRow($thread_id);
	}
	
	/**
	 * Get a thread by title.
	 * @param string $title
	 * @return GWF_ForumThread
	 */
	public static function getByTitle($title)
	{
		$title = self::escape($title);
		return self::table(__CLASS__)->selectFirst("thread_title='$title'");
	}
	
	#############
	### HREFs ###
	#############
	public function hrefAddPoll()
	{
		return GWF_WEB_ROOT.'thread_add_poll/'.$this->getID().'/'.$this->urlencodeSEO('thread_title');
	}

	public function getPostHREF(GWF_ForumPost $post, $term='')
	{
		$module = Module_Forum::getInstance();
		$ipp = $module->getPostsPerThread();
		$tid = $this->getID();
		$cut = $post->getVar('post_date');
		$nItems = $post->countRows("post_tid=$tid AND post_date<'$cut'");
		$page = GWF_PageMenu::getPagecount($ipp, $nItems+1);
		return $this->getPageHREF($page, $term).'#post'.$post->getID();
	}

	public function getLastPageHREF($censored=false)
	{
		$module = Module_Forum::getInstance();
		$last_page = GWF_PageMenu::getPagecount($module->getPostsPerThread(), $this->getPostCount());
		return $this->getPageHREF($last_page, '', $censored).'#post'.$this->getVar('thread_lastpost');
	}
	
	public function getPageHREF($page, $term='', $censored=false)
	{
		$page = $page == 1 ? '' : '-p'.intval($page,10);
		$title = $censored === false ? $this->urlencodeSEO('thread_title') : GWF_HTML::lang('unknown');
		$term = $term === '' ? '' : '-'.urlencode($term);
		return GWF_WEB_ROOT.sprintf('forum-t%s/%s%s.html%s', $this->getID(), $title, $page, $term);
	}

	public function getReplyHREF()
	{
		return sprintf('%sforum/reply/to/thread/%s/%s#form', GWF_WEB_ROOT, $this->getVar('thread_tid'), $this->urlencodeSEO('thread_title'));
	}

	public function getSubscribeHREF()
	{
		return sprintf('%sforum/subscribe/to/%s/%s', GWF_WEB_ROOT, $this->getVar('thread_tid'), $this->urlencodeSEO('thread_title'));
	}

	public function getUnSubscribeHREF()
	{
		return sprintf('%sforum/unsubscribe/from/%s/%s', GWF_WEB_ROOT, $this->getVar('thread_tid'), $this->urlencodeSEO('thread_title'));
	}

	public function getExternalUnSubscribeHREF($userid, $token)
	{
		return sprintf('%sforum/unsubscribe/%s/%s/from/%s/%s', GWF_WEB_ROOT, $userid, $token, $this->getVar('thread_tid'), $this->urlencodeSEO('thread_title'));
	}

	public function getExternalUnSubscribeAllHREF($userid, $token)
	{
		return sprintf('%sforum/unsubscribe/%s/%s/from/all', GWF_WEB_ROOT, $userid, $token);
	}

	public function getFirstPosterLink()
	{
		if ('' === ($username = $this->getVar('thread_firstposter'))) {
			return GWF_HTML::lang('guest');
		}
		$href = sprintf('%sprofile/%s', GWF_WEB_ROOT, urlencode($username));
		return GWF_HTML::anchor($href, $username);
	}

	public function getLastPosterLink()
	{
		if ($this->getPostCount() === 1) {
			return '';
		}
		if ('' === ($username = $this->getVar('thread_lastposter'))) {
			return GWF_HTML::lang('guest');
		}
		$href = sprintf('%sprofile/%s', GWF_WEB_ROOT, urlencode($username));
		return GWF_HTML::anchor($href, $username);
	}

	public function getEditHREF()
	{
		return GWF_WEB_ROOT.sprintf('forum/edit/thread/%s/%s', $this->getVar('thread_tid'), $this->urlencode('thread_title'));
	}

	###################
	### Permissions ###
	###################
	public static function getPermQuery()
	{
		if ('0' === ($uid = GWF_Session::getUserID())) {
			return 'thread_gid=0 AND thread_options&'.self::GUEST_VIEW;
		}
		else {
			$grp = GWF_TABLE_PREFIX.'usergroup';
			return "(thread_gid=0 OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=thread_gid))";
		}
	}

	public function hasPermission($user)
	{
		if ('0' === ($gid = $this->getGroupID())) {
			return true;
		}
		if ($user === false) {
			return false;
		}
		return $user->isInGroupID($gid);
	}

	public function hasReplyPermission($user, Module_Forum $module)
	{
		# Closed
		if ($this->isClosed())
		{
			return false;
		}

		# Still in moderation
		if ($this->isInModeration())
		{
			return false;
		}

		# Not even read
		if (!$this->hasPermission($user))
		{
			return false;
		}
		
		# No guest posts
		if ($user === false)
		{
			if (!$module->isGuestPostAllowed())
			{
				return false;
			}
			if (!$this->getBoard()->isGuestPostAllowed())
			{
				return false;
			}
		}
		else
		{
			$user instanceof GWF_User;
			if ($user->isWebspider())
			{
				return false;
			}
			if ($user->getLevel() < $module->cfgPostMinLevel())
			{
				return false;
			}
		}

		return true;
	}

	public function hasEditPermission($user=true)
	{
		if ($user === true)
		{
			$user = GWF_Session::getUser();
		}

		if ($user === false)
		{
			return false;
		}

		if ($user->isInGroupName('moderator'))
		{
			return true;
		}
		
		$gid = $this->getGroupID();
		if (!$user->isInGroupID($gid))
		{
			return false;
		}
		
		$ugo = $user->getUserGroupOptions($gid);
		if (($ugo &(GWF_UserGroup::MODERATOR|GWF_UserGroup::CO_LEADER|GWF_UserGroup::LEADER)) > 0) {
			return true;
		}

		return false;
	}

	public function canSubscribe()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return false;
		}

		if (false === ($user->hasValidMail())) {
			return false;
		}

		if (GWF_ForumSubscription::hasSubscribedManually($user, $this->getID())) {
			return false;
		}

		if (false === ($options = GWF_ForumOptions::getUserOptions($user))) {
			return false;
		}

		if ($options->isSubscribeAll()) {
			return false;
		}

		if ($options->isSubscribeOwn() && $this->hasUserPosted($user)) {
			return false;
		}

		return true;
	}

	public function canUnSubscribe()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return false;
		}

		if (GWF_ForumSubscription::hasSubscribedManually($user, $this->getID())) {
			return true;
		}

		return false;
	}

	public function mayAddPoll($user)
	{
		if ($user instanceof GWF_User)
		{
			if ($user->isInGroupName('moderator')) {
				return true;
			}
				
			if (false === ($fp = $this->getFirstPost())) {
				return false;
			}
				
			if ($user->getID() === $fp->getUserID(false)) {
				return true;
			}
		}
		return false;
	}

	#######################
	### Has User Posted ###
	#######################
	public function hasUserPosted(GWF_User $user)
	{
		$posts = new GWF_ForumPost(false);
		$uid = $user->getID();
		$tid = $this->getID();
		return $posts->selectFirst("post_uid=$uid AND post_tid=$tid") !== false;
	}

	####################
	### Get a thread ###
	####################
	/**
	* @param $thread_id int
	* @return GWF_ForumThread
	*/
	public static function getThread($thread_id)
	{
		return GDO::table(__CLASS__)->getRow($thread_id);
	}

	#######################
	### Get Thread Page ###
	#######################
	public static function getThreadPage($bid, $count, $page, $orderby='')
	{
		$bid = (int) $bid;
		$count = (int) $count;
		$page = (int) $page;
		$from = GWF_PageMenu::getFrom($page, $count);
		$sticky = self::STICKY;
		$permquery = self::getPermQuery();
		$threads = new self(false);
		$moderated = self::IN_MODERATION;
//		$orderby = $orderby === '' ? '' : 'thread_options&$sticky DESC, '.$orderby;
		return $threads->selectObjects('*', "(thread_bid=$bid) AND ($permquery) AND (thread_options&$moderated=0)", $orderby, $count, $from);
	}

	/**
	 * Get a page of posts. Hide or show posts that are in moderation.
	 * @param int $count
	 * @param int $page
	 * @param boolean $in_mod
	 * @return array
	 */
	public function getPostPage($count, $page, $in_mod=false)
	{
		$tid = $this->getID();
//		$options = GDO::table('GWF_ForumOptions');
		$posts = GDO::table('GWF_ForumPost');
		if (!$in_mod)
		{
			$mod = GWF_ForumPost::IN_MODERATION;
			$in_mod = "post_options&$mod=0";
		}
		else
		{
			$in_mod = '1';
		}
		$condition = "post_tid=$tid AND ($in_mod)";
		return $posts->selectObjects('*', $condition, "post_date ASC", $count, GWF_PageMenu::getFrom($page, $count));
	}

	#######################
	### Static Creation ###
	#######################
	/**
	* Create a new thread that can be used as a fake thread.
	* You can also call insert() on it, and it becomes a real row.
	* @param unknown_type $user GWF_User or false
	* @param unknown_type $title string
	* @param unknown_type $boardid int
	* @param unknown_type $groupid int
	* @param unknown_type $postcount int
	* @param unknown_type $options int
	* @return GWF_ForumThread
	*/
	public static function fakeThread($user=false, $title, $boardid=0, $groupid=0, $postcount=1, $options=0, $date=true)
	{
		if ($user === false) {
			$userid = 0;
			$username = '';
		} else {
			$userid = $user->getID();
			$username = $user->getVar('user_name');
		}
		
		$date = is_bool($date) ? GWF_Time::getDate(GWF_Date::LEN_SECOND) : $date;
		
		return new self(array(
			'thread_tid' => 0,
			'thread_bid' => $boardid,
			'thread_gid' => $groupid,
			'thread_uid' => $userid,

			'thread_firstposter' => $username,
			'thread_firstdate' => $date,

			'thread_lastpost' => 0,
			'thread_lastposter' => $username,
			'thread_lastdate' => $date,

			'thread_title' => $title,
			'thread_options' => $options,
			'thread_postcount' => $postcount,
			'thread_viewcount' => 0,
			'thread_watchers' => 0,

			'thread_thanks' => 0,
			'thread_votes_up' => 0,
			'thread_votes_down' => 0,

			'thread_unread' => $user === false ? ':' : ':'.$user->getID().':',

			'thread_pollid' => 0,
		
			'thread_force_unread' => ':',
		));
	}

	#####################
	### Get Last Post ###
	#####################
	/**
	* @return GWF_ForumPost
	*/
	public function getFirstPost()
	{
		return self::table('GWF_ForumPost')->selectFirstObject('*', 'post_tid='.$this->getID(), "post_date ASC");
	}

	/**
	 * @return GWF_ForumPost
	 */
	public function getLastPost()
	{
		return self::table('GWF_ForumPost')->selectFirstObject('*', 'post_tid='.$this->getID(), "post_date DESC");
	}

	/**
	 * In case we modify the treadlist in any obscure way, we shall call this to adjust the posters.
	 * @return unknown_type
	 */
	public function updateLastPost()
	{
		$firstpost = $this->getFirstPost();
		$lastpost = $this->getLastPost();
		return $this->saveVars(array(
			'thread_firstposter' => $firstpost ? $firstpost->getPosterName() : '',
			'thread_firstdate' => $firstpost ? $firstpost->getVar('post_date') : '',
			'thread_lastposter' => $lastpost ? $lastpost->getPosterName() : '',
			'thread_lastdate' => $lastpost ? $lastpost->getVar('post_date') : '',
			'thread_lastpost' => $lastpost ? $lastpost->getID() : 0,
		));
	}

	##############
	### Delete ###
	##############
	public function deleteThread()
	{
		$tid = $this->getID();
		$posts = new GWF_ForumPost(false);
		if (false === ($posts = $posts->selectObjects('*', "post_tid=$tid"))) {
			return false;
		}

		$toDelete = count($posts);

		foreach ($posts as $post)
		{
			$post->delete();
		}

		$this->delete();

		if (!$this->isInModeration())
		{
			$this->getBoard()->adjustCounters(-1, -$toDelete);
		}

		return true;
	}

	##########################
	### New Unread Threads ###
	##########################
	public function hasRead($user)
	{
		if ($user === false) {
			return true;
		}
		$user instanceof GWF_User;
		
		$uid = $user->getVar('user_id');
		if (strpos($this->getVar('thread_force_unread'), ":$uid:") !== false) {
			return false;
		}

		$stamp = self::getReadStamp($user);
		if ($stamp > $this->getVar('thread_lastdate')) {
			return true;
		}
		
		return strpos($this->getVar('thread_unread'), ":$uid:") !== false;
	}
	
	private static function getReadStamp(GWF_User $user)
	{
		$data = $user->getUserData();
		return isset($data[self::STAMP_NAME]) ? $data[self::STAMP_NAME] : $user->getVar('user_regdate');
	}

	public function markRead(GWF_User $user)
	{
		if ($this->hasRead($user)) {
			return true;
		}
		else {
			$uid = $user->getVar('user_id');
			return $this->saveVars(array(
				'thread_unread' => $this->getVar('thread_unread').$uid.':',
				'thread_force_unread' => str_replace(":$uid:", ':', $this->getVar('thread_force_unread')),
			));
		}
	}

	public static function getUnreadThreadCount($user)
	{
		$unread = true;
		//		static $unread = true;
		if ($unread === true)
		{
			if ($user === false) {
				$unread = 0;
			}
			else {
				$unread = self::table(__CLASS__)->countRows(self::getUnreadQuery($user));
			}
		}
		return $unread;
	}

	public static function getUnreadQuery(GWF_User $user)
	{
		$uid = $user->getID();
		$permquery = self::getPermQuery();
		$in_mod = GWF_ForumThread::IN_MODERATION;
		$regtimequery = sprintf('thread_lastdate>=\'%s\'', self::getReadStamp($user));
		return "(thread_postcount>0 AND ($permquery) AND ($regtimequery OR thread_force_unread LIKE '%:$uid:%') AND (thread_options&$in_mod=0) AND (thread_unread NOT LIKE '%:$uid:%') )";
	}

	public static function hookAddToGroup(GWF_User $user, $gid)
	{
		$uid = $user->getVar('user_id');
		$regtimequery = sprintf('thread_firstdate<\'%s\'', self::getReadStamp($user));
		if (false === self::table(__CLASS__)->update("thread_force_unread=concat(thread_force_unread, '$uid:')", "thread_gid=$gid AND $regtimequery")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		return '';
	}
	
	######################
	### Latest Threads ###
	######################
	public static function getLatestThreads($amount)
	{
		static $latest = true;
		if ($latest === true)
		{
			if ($amount > 0) {
				$threads = new self(false);
				$permquery = self::getPermQuery();
				$mod = GWF_ForumThread::IN_MODERATION;
				$inv = GWF_ForumThread::INVISIBLE;
				$latest = $threads->selectObjects('*', "thread_postcount > 0 AND ($permquery) AND (thread_options&$mod=0) AND (thread_options&$inv=0)", 'thread_lastdate DESC', $amount);
			} else {
				$latest = array();
			}
		}
		return $latest;
	}

	###############
	### Approve ###
	###############
	/**
	* Make thread visible.
	* Send out emails.
	* Adjust Board counter.
	* if param is true, it will not toggle the MODERATION bits because that has been done already in AddThread.
	* @param boolean $toggle_options
	* @return boolean
	*/
	public function onApprove($mail_out=true, $postcount=1)
	{
		if (false === ($this->updateLastPost())) {
			echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			return false;
		}

		
		# Do we have a post?
		if (false !== ($post = $this->getFirstPost()))
		{
			if ($mail_out === true)
			{
				if (false === $post->saveOption(GWF_ForumPost::MAIL_OUT, true)) {
					echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
					return false;
				}
			}
	
			if (false !== ($opts = $post->getUserOptions(false))) {
				if (false === $opts->increasePosts($postcount)) {
					echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
					return false;
				}
			}
		}

		
		# Do we have a board?
		if (false !== ($board = $this->getBoard()))
		{
			if (false === ($board->adjustCounters(1, $postcount))) {
				echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
				return false;
			}
		}

		if (false === ($this->saveOption(self::IN_MODERATION, false))) {
			echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			return false;
		}

		return true;
	}

	#############
	### Hooks ###
	#############
	public static function hookRenameUser(GWF_User $user, $new_username)
	{
		$threads = GDO::table(__CLASS__);
		$new_username = $threads->escape($new_username);
		$old_username = $threads->escape($user->getVar('user_name'));

		if (false === $threads->update("thread_firstposter='$new_username'", "thread_firstposter='$old_username'")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		if (false === $threads->update("thread_lastposter='$new_username'", "thread_lastposter='$old_username'")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		return true;
	}

	public static function hookDeleteUser(GWF_User $user)
	{
		$uid = $user->getID();
		$threads =  self::table(__CLASS__);
		$username = $threads->escape($user->getVar('user_name'));

		if (false === $threads->update("thread_firstposter=''", "thread_firstposter='$username'")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		if (false === $threads->update("thread_lastposter=''", "thread_lastposter='$username'")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		if (false === $threads->update("thread_uid=0", "thread_uid=$uid")) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		return true;
	}

	#############
	### Merge ###
	#############
	public function getMergeSelect($name)
	{
		$bid = $this->getBoardID();

		if (false === ($threads = $this->selectObjects('*', "thread_bid=$bid", "thread_firstdate"))) {
			return '';
		}

		$back = sprintf('<select name="%s">', $name);
		foreach ($threads as $t)
		{
			$id = $t->getID();
			$back .= sprintf('<option value="%d"%s>%s</option>', $id, GWF_HTML::selected($this->getID()===$id), $t->display('thread_title'));
		}
		$back .= '</select>';
		return $back;
	}

	/**
	 * Change guest view option for thread,post
	 * @param unknown_type $bool
	 * @return unknown_type
	 */
	public function saveGuestView($bool)
	{
		// Save for thread
		$this->saveOption(self::GUEST_VIEW, $bool);

		// Save for posts
		$tid = $this->getID();
		$posts = GDO::table('GWF_ForumPost');
		if (false === ($result = $posts->select('*', "post_tid=$tid"))) {
			return false;
		}
		while (false !== ($post = $posts->fetchObject($result, GDO::ARRAY_O)))
		{
			$post instanceof GWF_ForumPost;
			$post->saveOption(GWF_ForumPost::GUEST_VIEW, $bool);
		}
		$posts->free($result);
		return true;

	}
	
	/**
	 * Change groupid for thread,post
	 * @param unknown_type $bool
	 * @return unknown_type
	 */
	public function saveGroupID($gid)
	{
		// Save for thread
		$this->saveVar('thread_gid', $gid);

		// Save for posts
		$tid = $this->getID();
		$posts = GDO::table('GWF_ForumPost');
		if (false === ($result = $posts->select('*', "post_tid=$tid"))) {
			return false;
		}
		while (false !== ($post = $posts->fetch($result, GDO::ARRAY_O)))
		{
			$post instanceof GWF_ForumPost;
			$post->saveVar('post_gid', $gid);
		}
		$posts->free($result);
		return true;

	}

	##############
	### Helper ###
	##############
	public static function newThread(GWF_User $user, $title='', $message='', $options=0, $bid=0, $gid=0)
	{
		// No params
		if ($title === '' && $message === '') {
			return false;
		}
		
		// insert thread
		$postcount = $message === '' ? 0 : 1;
		$thread = self::fakeThread($user, $title, $bid, $gid, $postcount, $options);
		if (false === $thread->insert()) {
			return false;
		}

		// Insert message if there is one.
		if ($message !== '')
		{
			$threadid = $thread->getID();
			$post = GWF_ForumPost::fakePost($user, $title, $message, $options, $threadid, $gid);
			if (false === $post->insert()) {
				return false;
			}
		}
		
		$thread->onApprove(false, $postcount);
		
		Module_Forum::getInstance()->cachePostcount();
		
		return $thread;
	}

	#################
	### Prev/Next ###
	#################
	/**
	 * Get the previous thread in the same board ordered by firstpostdate 
	 * @return GWF_ForumThread
	 */
	public function getPrevThread()
	{
		$tid = $this->getVar('thread_tid');
		$bid = $this->getBoardID();
		$permissions = $this->getPermQuery();
		$date = $this->getVar('thread_lastdate');
		$orderby = 'thread_lastdate DESC';
		$order = "thread_lastdate<'$date' OR (thread_lastdate='$date' AND thread_tid<$tid)";
		return self::table(__CLASS__)->selectFirstObject('*', "thread_bid=$bid AND ($permissions) AND ($order)", $orderby);
	}
	
	/**
	 * Get the next thread in the same board ordered by firstpostdate 
	 * @return GWF_ForumThread
	 */
	public function getNextThread()
	{
		$bid = $this->getBoardID();
		$tid = $this->getVar('thread_tid');
		$permissions = $this->getPermQuery();
		$date = $this->getVar('thread_lastdate');
		$orderby = 'thread_lastdate ASC';
		$order = "thread_lastdate>'$date' OR (thread_lastdate='$date' AND thread_tid>$tid)";
		return self::table(__CLASS__)->selectFirstObject('*', "thread_bid=$bid AND ($permissions) AND ($order)", $orderby);
	}
}

?>