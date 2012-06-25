<?php
/**
 * @author gizmore
 */
final class GWF_ForumBoard extends GDO
{
	###################
	### Option Bits ###
	###################
	const ALLOW_THREADS = 0x01;
	const LOCKED = 0x02;
	const GUEST_POSTS = 0x04;
	const SCRIPT_LOCK = 0x08;
	const GUEST_VIEW = 0x10;
	const INVISIBLE = 0x20;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumboard'; }
	public function getOptionsName() { return 'board_options'; }
	
	public function getColumnDefines()
	{
		return array(
			'board_bid' => array(GDO::AUTO_INCREMENT), // Board ID
			'board_pid' => array(GDO::INT|GDO::UNSIGNED|GDO::INDEX, 0), // Parent ID
			'board_gid' => array(GDO::INT|GDO::UNSIGNED, 0), // Group ID
		
			'board_pos' => array(GDO::UINT, true), // Position/order
			'board_options' => array(GDO::UINT, 0), 
		
			'board_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'board_descr' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
		
			'board_postcount' => array(GDO::UINT, 0),
			'board_threadcount' => array(GDO::UINT, 0),
		);
	}
	
	# Convinience
	public function getID() { return $this->getVar('board_bid'); }
	public function getGroupID() { return $this->getVar('board_gid'); }
	public function getParentID() { return $this->getVar('board_pid'); }
	public function getPostCount() { return $this->getVar('board_postcount'); }
	public function getThreadCount() { return $this->getVar('board_threadcount'); }
	public function isThreadAllowed() { return $this->isOptionEnabled(self::ALLOW_THREADS); }
	public function isLocked() { return $this->isOptionEnabled(self::LOCKED); }
	public function isGuestPostAllowed() { return $this->isOptionEnabled(self::GUEST_POSTS); }
	public function isGuestView() { return $this->isOptionEnabled(self::GUEST_VIEW); }
	public function isRoot() { return $this->getVar('board_bid') === '1'; }
	public function setVisible($bool) { return $this->setInvisible(!$bool); }
	public function setInvisible($bool) { return $this->saveOption(self::INVISIBLE, $bool); }
	
	/**
	 * Query a board by ID
	 * @param int $bid
	 * @return GWF_ForumBoard
	 */
	public static function getByID($bid)
	{
		return self::table(__CLASS__)->getRow($bid);
	}
	
	/**
	 * Get a forum board by title. (Kinda very hacky, because of duplicate titles!)
	 * @param unknown_type $bid
	 * @return unknown_type
	 */
	public static function getByTitle($title)
	{
		$title = self::escape($title);
		return self::table(__CLASS__)->selectFirstObject('*', "board_title='$title' AND board_bid>1");
	}
	
	
	### Childcache
	private $childs = array();
	public function getChilds() { return $this->childs; }
	public function addChild(GWF_ForumBoard $board) { $this->childs[] = $board; }
	
	#############
	### HREFS ###
	#############
	public function getAddBoardHREF()
	{
		return sprintf('%sforum/add/board/%s/%s', GWF_WEB_ROOT, $this->getVar('board_bid'), $this->urlencode('board_title'));
	}
	
	public function getAddThreadHREF()
	{
		return sprintf('%sforum/add/thread/%s/%s', GWF_WEB_ROOT, $this->getVar('board_bid'), $this->urlencode('board_title'));
	}
	
	public function getEditBoardHREF()
	{
		return sprintf('%sforum/edit/board/%s/%s', GWF_WEB_ROOT, $this->getVar('board_bid'), $this->urlencode('board_title'));
	}
	
	public function getShowBoardHREF()
	{
		return GWF_WEB_ROOT.'forum-b'.$this->getVar('board_bid').'/'.$this->urlencodeSEO('board_title').'.html';
	}
	
	public function getMoveUpHREF()
	{
		return GWF_WEB_ROOT.sprintf('index.php?mo=Forum&me=Move&up=%s&bid=%s', $this->getVar('board_bid'), Common::getGet('bid', '1'));
	}
	
	public function getMoveDownHREF()
	{
		return GWF_WEB_ROOT.sprintf('index.php?mo=Forum&me=Move&down=%s&bid=%s', $this->getVar('board_bid'), Common::getGet('bid', '1'));
	}
	
	###################
	### Cached Init ###
	###################
	/**
	 * Lets just cache all boards (we may access), we need them anyway for quickjumps and stuff.
	 * @var boolean
	 */
	private static $boardcache;
	public static function init($with_permission=true, $flush_cache=false)
	{
		static $inited = false;
		if ($flush_cache===true || $inited===false) {
			$boards = self::table(__CLASS__);
			$permquery = $with_permission===true ? self::getPermQuery() : '';
			$bby = Common::getGet('bby', 'board_pos');
			$bdir = Common::getGet('bdir', 'ASC');
			$orderby = $boards->getMultiOrderby($bby, $bdir);
			if (false === ($all = $boards->selectObjects('*', $permquery, $orderby)))
			{
				return false;
			}
			
			# Put in keys :/
			self::$boardcache = array();
			foreach ($all as $board)
			{
				self::addBoardToCache($board);
			}
			
			# Assign childs
			foreach (self::$boardcache as $board)
			{
				$board instanceof GWF_ForumBoard;
				if ('0' !== ($pid = $board->getParentID()))
				{
					self::$boardcache[$pid]->addChild($board);	
				}
			}
			
			$inited = true;
		}
		return $inited === true;
	}
	
	/**
	 * Add a board to the boardcache.
	 * We need a lot of boards mostly, so it`s not too bad to cache em.
	 * @param GWF_ForumBoard $board
	 * @return unknown_type
	 */
	public static function addBoardToCache(GWF_ForumBoard $board)
	{
		self::$boardcache[$board->getID()] = $board;
	}
	
	public static function getBoards()
	{
		return self::$boardcache;
	}
	
	public function getBoardPage($page, $bpp)
	{
		$back = array_slice($this->getChilds(), GWF_PageMenu::getFrom($page, $bpp), $bpp, true);
		return $back;
	}
	
	/**
	 * @param $boardid int
	 * @return GWF_ForumBoard
	 */
	public static function getBoard($boardid)
	{
		$bid = (int) $boardid;
		return isset(self::$boardcache[$bid]) ? self::$boardcache[$bid] : false;
	}
	
	public static function getRoot()
	{
		return self::getBoard(1);
	}
	
	/**
	 * @return GWF_ForumBoard
	 */
	public function getParent()
	{
		if ('0' === ($pid = $this->getParentID())) {
			return false;
		}
		return self::$boardcache[$pid];
	}
	
	#######################
	### Static Creation ###
	#######################
	/**
	 * Create and insert a Forum Board. Returns new ForumBoard or false.
	 * @param string $title
	 * @param string $descr
	 * @param int $parentid
	 * @param int $options
	 * @param int $groupid
	 * @return GWF_ForumBoard
	 */
	public static function createBoard($title, $descr, $parentid=1, $options=0, $groupid=0)
	{
		$board = new self(array(
			'board_bid' => 0,
			'board_pid' => $parentid,
			'board_gid' => $groupid,
		
			'board_pos' => count(self::getBoards()) + 1,
			'board_options' => $options, 
		
			'board_title' => $title,
			'board_descr' => $descr,
		
			'board_postcount' => 0,
			'board_threadcount' => 0,
		));
		if (false === ($board->insert())) {
			return false;
		}
		
		self::addBoardToCache($board);
		
		return $board;
	}
	
	#######################
	### Get Thread Page ###
	#######################
	/**
	 * Return a page of threads for this board. (Some thread rows from DB)
	 * @param unknown_type $count
	 * @param unknown_type $page
	 * @return unknown_type
	 */
	public function getThreads($count, $page, $orderby)
	{
		return GWF_ForumThread::getThreadPage($this->getID(), $count, $page, $orderby);
	}
	
	###################
	### Permissions ###
	###################
	/**
	 * A query to check if userid can access boardid.
	 * @return string SQL Query portion
	 */
	public static function getPermQuery()
	{
		if ('0' === ($uid = GWF_Session::getUserID())) {
			return 'board_gid=0 and board_options&'.self::GUEST_VIEW;
		}
		else {
			$grp = GWF_TABLE_PREFIX.'usergroup';
			$invisible = self::INVISIBLE;
			return "board_options&$invisible=0 AND ((board_gid=0) OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=board_gid))";
		}
	}
		
	/**
	 * Check if new threads are allowed in this board for current user.
	 * @return boolean
	 */
	public function isNewThreadAllowed()
	{
		if (!$this->isOptionEnabled(self::ALLOW_THREADS)) {
			return false;
		}
		if ($this->isOptionEnabled(self::LOCKED)) {
			return false;
		}
		
		if (false === ($user = GWF_Session::getUser()))
		{
			if (!$this->isGuestPostAllowed()) {
				return false;
			}
			if (!Module_Forum::getInstance()->isGuestPostAllowed()) {
				return false;
			}
		}
		return $this->hasPermissionS();
	}
	
	/**
	 * Check Board Permission by Cache.
	 * @return true or false
	 */
	public function hasPermissionS()
	{
		$user = GWF_Session::getUser();
		
//		if ($user !== false && $user->isWebspider()) {
//			return false;
//		}
		
		if ('0' === ($gid = $this->getGroupID())) {
			return true;
		}
		
		if ($user === false) {
			return false;
		}
		
		if ($user->isAdmin()) {
			return true;
		}
		
		if ($user->isInGroupID($gid)) {
			return true;
		}
		
		return false;
	}
	
	##################
	### Board Tree ###
	##################
	private $bt_cache = true;
	/**
	 * Get a forum board tree, as array of array(_reserved, boardid, title).
	 * @return array(array(_reserved, boardid, title))
	 */
	public function getBoardTree()
	{
		if ($this->bt_cache === true)
		{
			$this->bt_cache = $this->getBoardTreeB();
		}
		return $this->bt_cache;
	}
	
	/**
	 * Get a forum board tree.
	 * like foo->bar->blub
	 * @return array(array())
	 */
	private function getBoardTreeB()
	{
		$back = array();
		$current = $this;
		while ($current !== false)
		{
			$back[] = array('b', $current->getID(), $current->getVar('board_title'));
			$current = $current->getParent();
		}
		return array_reverse($back, false);
	}
	
	##############
	### Delete ###
	##############
	/**
	 * Delete a board and all it`s threads.
	 * @return true|false
	 */
	public function deleteBoard()
	{
		$back = true;
		$bid = $this->getID();
		if (false === ($threads = GDO::table('GWF_ForumThread')->selectObjects('*', "thread_bid={$bid}"))) {
			return false;
		}
		
		foreach ($threads as $thread)
		{
			if (false === $thread->deleteThread()) {
				$back = false;
			}
		}
		
		if (false === $this->delete()) {
			$back = false;
		}
		
		return $back;
	}
	
	##################
	### Postcounts ###
	##################
	/**
	 * Adjust Thread and postcount for this board and it`s parents.
	 * @param int $threadcount
	 * @param int $postcount
	 * @return true|false
	 */ 
	public function adjustCounters($threadcount, $postcount)
	{
		$threadcount = (int) $threadcount;
		$postcount = (int) $postcount;
		
		$current = $this;
		while ($current !== false)
		{
			if ($threadcount !== 0) {
				if (false === $current->increase('board_threadcount', $threadcount)) {
					return false;
				}
			}
			if ($postcount !== 0) {
				if (false === $current->increase('board_postcount', $postcount)) {
					return false;
				}
			}			
			$current = $current->getParent();
		}
		return true;
	}
	
	############
	### Move ###
	############
	/**
	 * Move this board to another.
	 * @param GWF_ForumBoard $newParent
	 * @return true|false
	 */
	public function move(GWF_ForumBoard $newParent)
	{
		$newpid = $newParent->getID();
		if (false === $this->getParent()->adjustCounters(-$this->getThreadCount(), -$this->getPostCount())) {
			return false;
		}
		if (false === $this->saveVar('board_pid', $newParent->getID())) {
			return false;
		}
		if (false === $newParent->adjustCounters($this->getThreadCount(), $this->getPostCount())) {
			return false;
		}
		return true;
	}
	
	/**
	 * Change guest view option for board,threads,posts
	 * @param boolean $bool
	 * @return boolean
	 */
	public function saveGuestView($bool)
	{
		// Save for board
		$this->saveOption(self::GUEST_VIEW, $bool);

		// Save for threads
		$bid = $this->getID();
		$threads = GDO::table('GWF_ForumThread');
		if (false === ($result = $threads->select('*', "thread_bid=$bid"))) {
			return false;
		}
		while (false !== ($thread = $threads->fetch($result, GDO::ARRAY_O)))
		{
			$thread instanceof GWF_ForumThread;
			$thread->saveGuestView($bool);
		}
		$threads->free($result);
		
		return true;
	}
	
	/**
	 * Change GroupID deep for board,threads,posts.
	 * @param int $gid
	 * @return boolean
	 */
	public function saveGroupID($gid)
	{
		// Save for board
		$this->saveVar('board_gid', $gid);
		
		// Save for threads
		$bid = $this->getID();
		$threads = GDO::table('GWF_ForumThread');
		if (false === ($result = $threads->select('*', "thread_bid=$bid"))) {
			return false;
		}
		while (false !== ($thread = $threads->fetch($result, GDO::ARRAY_O)))
		{
			$thread instanceof GWF_ForumThread;
			$thread->saveGroupID($gid);
		}
		$threads->free($result);
		return true;
	}
	
	#######################
	### Subscribe board ###
	#######################
	public function canSubscribe()
	{
		$fopts = GWF_ForumOptions::getUserOptionsS();
		if ($fopts->getVar('fopt_subscr') === GWF_ForumOptions::SUBSCRIBE_ALL)
		{
			return false;
		}
		if (GWF_ForumSubscrBoard::hasSubscribed(GWF_Session::getUserID(), $this->getID()))
		{
			return false;
		}
		return true;
	}

	public function canUnSubscribe()
	{
		return GWF_ForumSubscrBoard::hasSubscribed(GWF_Session::getUserID(), $this->getID());
	}
	
	public function getSubscribeHREF()
	{
		return GWF_WEB_ROOT.'index.php?mo=Forum&me=SubscribeBoard&subscribe='.$this->getID();
	}

	public function getUnSubscribeHREF()
	{
		return GWF_WEB_ROOT.'index.php?mo=Forum&me=SubscribeBoard&unsubscribe='.$this->getID();
	}
}
?>