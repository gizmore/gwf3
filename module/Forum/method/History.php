<?php

final class Forum_History extends GWF_Method
{
	##################
	### GWF_Method ###
	##################
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^forum/history/by/page-(\d+)$ index.php?mo=Forum&me=History&by=&dir=&page=$1'.PHP_EOL.
			'RewriteRule ^forum/history/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Forum&me=History&by=$1&dir=$2&page=$3'.PHP_EOL.
			'RewriteRule ^forum/history$ index.php?mo=Forum&me=History&by=thread_lastdate&dir=ASC'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false === ($error = $this->sanitize($module))) {
			return $error;
		}
		
		return $this->templateLatest($module);
	}
	
	######################
	### Sanitize These ###
	######################
	private $threads;
	private $nThreads;
	private $tpp;
	private $page;
	private $nPages;
	private $by;
	private $dir;
	private $orderby;
	private $conditions;
	
	private function sanitize(Module_Forum $module)
	{
		$this->threads = GDO::table('GWF_ForumThread');
		$this->conditions = sprintf('thread_postcount>0 AND (%s) AND thread_options&%d=0', GWF_ForumThread::getPermQuery(), GWF_ForumThread::IN_MODERATION|GWF_ForumThread::INVISIBLE);
		$this->nThreads = $this->threads->countRows($this->conditions);
		$this->tpp = $module->getThreadsPerPage();
		$this->nPages = GWF_PageMenu::getPagecount($this->tpp, $this->nThreads);
		$this->page = Common::clamp(Common::getGet('page', $this->nPages), 1, $this->nPages);
		$this->by = $_GET['by'] = Common::getGet('by', 'thread_lastdate');
		$this->dir = $_GET['dir'] = Common::getGet('dir', 'ASC');
		$this->orderby = $this->threads->getMultiOrderby($this->by, $this->dir);
	}
	
	private function templateLatest(Module_Forum $module)
	{
		GWF_Website::setPageTitle($module->lang('pt_history', array($this->page, $this->nPages)));
		
		$tVars = array(
			'by' => $this->by,
			'dir' => $this->dir,
			'sort_url' => GWF_WEB_ROOT.'forum/history/by/%BY%/%DIR%/page-1',
			'pagemenu' => GWF_PageMenu::display($this->page, $this->nPages, sprintf('%sforum/history/by/%s/%s/page-%%PAGE%%', GWF_WEB_ROOT, $this->by, $this->dir)),
			'threads' => ($this->threads->selectObjects('*', $this->conditions, $this->orderby, $this->tpp, GWF_PageMenu::getFrom($this->page, $this->tpp))),
		);
		return $module->templatePHP('history.php', $tVars);
	}
	
}