<?php
final class Votes_Polls extends GWF_Method 
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^show_poll/(\d+)/[^/]+$ index.php?mo=Votes&me=Polls&show=$1'.PHP_EOL.
			'RewriteRule ^poll_overview$ index.php?mo=Votes&me=Polls'.PHP_EOL.
			'RewriteRule ^poll_overview/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Votes&me=Polls&by=$1&dir=$2&page=$3'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		if (false !== ($pollid = Common::getGet('show'))) {
			return $this->templatePoll($module, $pollid);
		}
		
		return $this->templatePolls($module);
	}
	
	private function templatePolls(Module_Votes $module)
	{
		$ipp = 25;
		$t = GDO::table('GWF_VoteMulti');
		$user = GWF_Session::getUser();
		$conditions = GWF_VoteMulti::permqueryRead($user);
		$nItems = $t->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page')), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$by = Common::getGet('by', 'vm_date');
		$dir = Common::getGet('dir', 'DESC');
		$orderby = $t->getMultiOrderby($by, $dir);
		
		$tVars = array(
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'poll_overview/by/'.urlencode($by).'/'.urlencode($dir).'/page-%PAGE%'),
			'polls' => $t->selectObjects('*', $conditions, $orderby, $ipp, $from),
			'sort_url' => GWF_WEB_ROOT.'poll_overview/by/%BY%/%DIR%/page-1',
			'may_add_poll' => Module_Votes::mayAddPoll($user),
			'href_add_poll' => GWF_WEB_ROOT.'poll/add',
		);
		return $module->templatePHP('polls.php', $tVars);
	}

	private function templatePoll(Module_Votes $module, $pollid)
	{
		if (false === ($poll = GWF_VoteMulti::getByID($pollid))) {
			return $module->error('err_poll').$this->templatePolls($module);
		}
		
		return $poll->showResults(300);
	}
}
?>