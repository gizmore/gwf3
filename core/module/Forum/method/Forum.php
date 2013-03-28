<?php
/**
 * Show a board and it`s threads.
 * @author gizmore
 *
 */
final class Forum_Forum extends GWF_Method
{
	/**
	 * @var GWF_ForumBoard
	 */
	private $board = false;
	/**
	 * @var array GWF_ForumThread
	 */
	private $threads = array();
	private $page = 1;
	private $nPages = 1;
	private $nThreads = 0;
	private $tpp = 1;
	
	public function getHTAccess()
	{
		$back = '';
		if ($this->module->cfgOldURLS())
		{
			$back .=
// 			'RewriteRule ^forum$ index.php?mo=Forum&me=Forum&bid=1&page=1'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+$ index.php?mo=Forum&me=Forum&bid=$1&bpage=1'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bby/([^/]+)/([DEASC,]+)/bpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bby=$2&bdir=$3&bpage=$4'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bby/bpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)/tpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2&tpage=$3'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)/tby/to/tpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2&tpage=$3'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)/tby/([^/]+)/to/([DEASC,]+)/tpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2&tpage=$3&tby=$4&tdir=$5'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/tby/([^/]+)/to/([DEASC,]+)/tpage-(\d+)$ index.php?mo=Forum&me=Forum&bid=$1&tpage=$4&tby=$2&tdir=$3'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)/tpage-(\d+)/tby/to/$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2&tpage=$3'.PHP_EOL.
			'RewriteRule ^forum/board/(\d+)/[^/]+/bpage-(\d+)/tpage-(\d+)/tby/([^/]+)/to/([^/]+)$ index.php?mo=Forum&me=Forum&bid=$1&bpage=$2&tpage=$3&tby=$4&tdir=$5'.PHP_EOL;
		}		
		return
			$back.
			'RewriteRule ^forum/?$ index.php?mo=Forum&me=Forum&bid=1&page=1'.PHP_EOL.
			'RewriteRule ^forum-b(\d+)/[^/\-]+\.html/?$ index.php?mo=Forum&me=Forum&bid=$1&bpage=1'.PHP_EOL.
			'RewriteRule ^forum-b(\d+)/tby/([^/]+)/([DEASC,]+)/[^/\-]+-p(\d+)\.html$ index.php?mo=Forum&me=Forum&bid=$1&tby=$2&tdir=$3&tpage=$4'.PHP_EOL.
			'RewriteRule ^forum-b(\d+)/bby/([^/]+)/([DEASC,]+)/[^/\-]+-p(\d+)\.html$ index.php?mo=Forum&me=Forum&bid=$1&bby=$2&bdir=$3&bpage=$4'.PHP_EOL.
			'RewriteRule ^forum-b(\d+)/bby/([^/]+)/([DEASC,]+)/bp-(\d+)/tby/([^/]+)/([DEASC,]+)/[^/\-]+-p(\d+)\.html$ index.php?mo=Forum&me=Forum&bid=$1&bby=$2&bdir=$3&bpage=$4&tby=$5&tdir=$6&tpage=$7'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'forum',
						'page_title' => 'Forum',
						'page_meta_desc' => GWF_SITENAME.' Forum',
				),
		);
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		
		GWF_Website::setPageTitle($this->module->lang('pt_board', array($this->board->getVar('board_title'))));
		GWF_Website::setMetaDescr($this->module->lang('md_board', array($this->board->getVar('board_descr'))));
		GWF_Website::setMetaTags($this->module->lang('mt_board'));
		
		if (false !== (Common::getGet('mark_all_read')))
		{
			return $this->markAllRead().$this->templateForum();
		}
		
		return $this->templateForum();
	}
	
	public function sanitize()
	{
		if (false === ($this->board = $this->module->getCurrentBoard()))
		{
			return $this->module->error('err_board');
		}
		$threads = GDO::table('GWF_ForumThread');
		$bid = $this->board->getID();
		$this->tpp = $this->module->getThreadsPerPage();
		$this->nThreads = $threads->countRows("thread_bid=$bid");
		$this->nPages = GWF_PageMenu::getPagecount($this->tpp, $this->nThreads);
		$this->page = Common::clamp((int)Common::getGet('tpage', '1'), 1, $this->nPages);
		
		$this->nBoards = count($this->board->getChilds());
		$this->nBPages = GWF_PageMenu::getPagecount($this->tpp, $this->nBoards);
		$this->bPage = Common::clamp(Common::getGet('bpage', 1), 1, $this->nBPages);
		
		return false;
	}

	public function templateForum()
	{
		$by = urlencode(Common::getGetString('tby', 'thread_lastdate'));
		$dir = urlencode(Common::getGetString('tdir', 'DESC'));
		$bby = urlencode(Common::getGetString('bby', 'board_pos'));
		$bdir = urlencode(Common::getGetString('bdir', 'ASC'));
		$orderby = GDO::table('GWF_ForumThread')->getMultiOrderby($by, $dir);
		$bid = $this->board->getVar('board_bid');
		$bt = $this->board->urlencodeSEO('board_title');
		$tVars = array(
			'boards' => $this->board->getBoardPage($this->bPage, $this->tpp),
			'board' => $this->board,
			'pagemenu_boards' => GWF_PageMenu::display($this->bPage, $this->nBPages, sprintf(GWF_WEB_ROOT.'forum-b%s/bby/%s/%s/%s-p%%PAGE%%.html', $bid, $bby, $bdir, $bt)),
			'threads' => $this->board->getThreads($this->tpp, $this->page, $orderby),
			'pagemenu_threads' => GWF_PageMenu::display($this->page, $this->nPages, sprintf(GWF_WEB_ROOT.'forum-b%s/tby/%s/%s/%s-p%%PAGE%%.html', $bid, $by, $dir, $bt)),
			'new_thread_allowed' => $this->board->isNewThreadAllowed(),
			'unread_threads' => GWF_ForumThread::getUnreadThreadCount(GWF_Session::getUser()),
			'latest_threads' => GWF_ForumThread::getLatestThreads($this->module->getNumLatestThreads()),
			'href_options' => GWF_WEB_ROOT.'forum/options',
			'href_unread' => $this->module->getMethodURL('Unread'),
			'href_search' => GWF_WEB_ROOT.'forum/search',
			'board_sort_url' => GWF_WEB_ROOT.sprintf('forum-b%s/bby/%%BY%%/%%DIR%%/%s-p1.html', $bid, $bt),
//			'thread_sort_url' => GWF_WEB_ROOT.sprintf('forum-b%s/bby/ forum/board/%s/%s/bpage-%d/tpage-1/tby/%%BY%%/to/%%DIR%%', $bid, $bt, $this->bPage),
			'thread_sort_url' => GWF_WEB_ROOT.sprintf('forum-b%s/bby/%s/%s/bp-%d/tby/%%BY%%/%%DIR%%/%s-p1.html', $bid, $bby, $bdir, $this->bPage, $bt),
			'href_polls' => GWF_WEB_ROOT.'poll_overview',
		);
		return $this->module->templatePHP('forum.php', $tVars);
	}
}
?>