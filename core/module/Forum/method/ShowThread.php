<?php
/**
 * Show a forum thread
 * @author gizmore
 */
final class Forum_ShowThread extends GWF_Method
{
	################
	### HTAccess ### 
	################
	public function getHTAccess()
	{
		$back = '';
		if ($this->module->cfgOldURLS())
		{
			$back .=
			'RewriteRule ^forum/show/thread/([0-9]+)/[^/]+/?$ index.php?mo=Forum&me=ShowThread&tid=$1&page=1'.PHP_EOL.
			'RewriteRule ^forum/show/thread/([0-9]+)/[^/]+/page-([0-9]+)/?$ index.php?mo=Forum&me=ShowThread&tid=$1&page=$2'.PHP_EOL.
			'RewriteRule ^forum/show/thread/([0-9]+)/[^/]+/page-([0-9]+)/(.+)$ index.php?mo=Forum&me=ShowThread&tid=$1&page=$2&term=$3'.PHP_EOL;
		}
		return
			$back. 
			'RewriteRule ^forum-t([0-9]+)/[^/\-]+\.html$ index.php?mo=Forum&me=ShowThread&tid=$1&page=1'.PHP_EOL.
			'RewriteRule ^forum-t([0-9]+)/[^/\-]+\.html-([^/]+)$ index.php?mo=Forum&me=ShowThread&tid=$1&page=1&term=$2'.PHP_EOL.
			'RewriteRule ^forum-t([0-9]+)/[^/\-]+-p([0-9]+)\.html$ index.php?mo=Forum&me=ShowThread&tid=$1&page=$2'.PHP_EOL.
			'RewriteRule ^forum-t([0-9]+)/[^/\-]+-p([0-9]+).html-([^/]+)$ index.php?mo=Forum&me=ShowThread&tid=$1&page=$2&term=$3'.PHP_EOL;
	}
	
	################
	### Get Vars ###
	################
	
	/**
	 * @var GWF_ForumThread
	 */
	private $thread;
	
	# Sane GET vars :)
	private $page = 1;
	private $nPosts = 0;
	private $nPages = 1;
	private $ppt = 1;
	
	##############
	### Method ###
	##############
	public function execute()
	{
		GWF_ForumBoard::init(true);
		
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		if ($this->module->cfgUseGTranslate())
		{
			GWF_Website::addJavascript(Common::getProtocol().'://www.google.com/jsapi');
			GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Forum/gwf_forum.js');
			GWF_Website::addJavascriptInline('google.load("language", "1");');
		}
		
		GWF_Website::setPageTitle($this->module->lang('pt_thread', array($this->thread->getBoard()->getVar('board_title'), $this->thread->getVar('thread_title'))));
		
		return $this->templateThread();
	}
	#########################
	### Sanitize Get Vars ###
	#########################
	private function sanitize()
	{
		if (false === ($this->thread = GWF_ForumThread::getByID(Common::getGetString('tid')))) {
			return $this->module->error('err_thread');
		}
		
		$this->ppt = $this->module->getPostsPerThread();
		$this->nPosts = $this->thread->getPostCount();
		$this->nPages = GWF_PageMenu::getPagecount($this->ppt, $this->nPosts);
		$default_page = isset($_GET['last_page']) ? $this->nPages : 1;
		$this->page = Common::clamp(Common::getGetInt('page'), $default_page, $this->nPages);

		if (!$this->thread->hasPermission(GWF_Session::getUser())) {
			return $this->module->error('err_thread_perm');
		}
		
		if ($this->thread->isInModeration()) {
			return $this->module->error('err_in_mod');
		}
		
		return false;
	}
	
	###################
	### Show a page ###
	###################
	private function templateThread()
	{
		$this->thread->increase('thread_viewcount', 1);
		
		if (false !== ($user = GWF_Session::getUser())) {
			if (false === $this->thread->markRead($user)) {
				echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		
		$tVars = array(
			'thread' => $this->thread,
			'posts' => $this->thread->getPostPage($this->ppt, $this->page),
			'pagemenu' => $this->getPageMenu(),
			'actions' => true,
			'title' => true,
			'reply' => $this->thread->hasReplyPermission(GWF_Session::getUser(), $this->module),
			'nav' => true,
			'can_vote' => $user === false ? false : $this->module->cfgVotesEnabled(),
			'can_thank' => $user === false ? false : $this->module->cfgThanksEnabled(),
			'term' => GWF_QuickSearch::getQuickSearchHighlights(Common::getRequest('term', '')),
			'page' => $this->page,	
			'href_add_poll' => $this->thread->hrefAddPoll(),
			'href_edit' => $this->thread->getEditHREF(),
		);
		
		return $this->module->templatePHP('show_thread.php', $tVars);
	}
	
	private function getPageMenu()
	{
		$href = GWF_WEB_ROOT.sprintf('forum-t%s/%s-p%%PAGE%%.html', $this->thread->getID(), $this->thread->urlencodeSEO('thread_title'));
		return GWF_PageMenu::display($this->page, $this->nPages, $href);
	}
}

?>
