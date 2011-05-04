<?php

final class Chat_History extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^chat/history/for/([^/]+)/page-([0-9]+)$ index.php?mo=Chat&me=History&channel=$1&page=$2'.PHP_EOL.
			'RewriteRule ^chat/history/for/([^/]+)$ index.php?mo=Chat&me=History&channel=$1'.PHP_EOL.
			'RewriteRule ^chat/history/page-([0-9]+)$ index.php?mo=Chat&me=History&channel=&page=$1'.PHP_EOL.
			'RewriteRule ^chat/history$ index.php?mo=Chat&me=History'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		$this->sanitize($module);
		
		return $this->templateHistory($module);
	}
	
	private $channel = '';
	private $page = 1;
	private $nPages = 1;
	private $nItems = 0;
	private $ipp = 1;
	private function sanitize(Module_Chat $module)
	{
		$this->ipp = $module->getHistmsgPerPage();
		
		$channel = Common::getGet('channel', '');
		if (Common::startsWith($channel, 'G-')) {
			$channel = 'G#'.substr($channel, 2);
		}
		
		$this->channel = $module->getWhitelistedChannel($channel);
		$this->nItems = $module->countHistoryMessages($this->channel);
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp((int)Common::getGet('page', $this->nPages), 1, $this->nPages);
	}
	
	private function templateHistory(Module_Chat $module)
	{
		$pagemenuHREF = $this->channel === '' ? 'chat/history/page-%PAGE%' : 'chat/history/for/'.$this->channel.'/page-%PAGE%';
		$pagemenuHREF = GWF_WEB_ROOT.$pagemenuHREF;
		$tVars = array(
			'friends' => $module->getFriends(),
			'history' => $module->getHistoryMessages($this->channel, $this->page),
			'pagemenu' => GWF_PageMenu::display($this->page, $this->nPages, $pagemenuHREF),
			'prevpage' => GWF_PageMenu::prevPage($this->page, $this->nPages, $pagemenuHREF),
			'nextpage' => GWF_PageMenu::nextPage($this->page, $this->nPages, $pagemenuHREF),
		);
		return $module->templatePHP('history.php', $tVars);
	}
}

?>
