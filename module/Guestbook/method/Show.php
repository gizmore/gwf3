<?php
/**
 * Show a guestbook page.
 * @author gizmore
 */
final class Guestbook_Show extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^guestbook$ index.php?mo=Guestbook&me=Show&gbid=1'.PHP_EOL.
			'RewriteRule ^guestbook/show/page-(\d+)$ index.php?mo=Guestbook&me=Show&gbid=1&page=$1'.PHP_EOL.
			'RewriteRule ^guestbook/show/(\d+)$ index.php?mo=Guestbook&me=Show&gbid=$1'.PHP_EOL.
			'RewriteRule ^guestbook/show/(\d+)/page-(\d+)$ index.php?mo=Guestbook&me=Show&gbid=$1&page=$2'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		# Get GB
		if (false === ($gb = GWF_Guestbook::getByID(Common::getGet('gbid')))) {
			return $module->error('err_gb');
		}

		# SEO
		GWF_Website::setPageTitle($gb->displayTitle());
		GWF_Website::setMetaTags($gb->displayDescr());
		
		# Permission
		if (!$gb->canView(GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return $this->templateShow($module, $gb);
	}

	public function templateShow(Module_Guestbook $module, GWF_Guestbook $gb)
	{
		$nested = $gb->isNestingAllowed();
		
		if ($nested) {
			return $this->templateNested($module, $gb);
		}
		
		$user = GWF_Session::getUser();
		$can_moderate = $gb->canModerate($user);
		
		$gbid = $gb->getID();
		$mod = GWF_GuestbookMSG::IN_MODERATION;
		$conditions = "gbm_gbid=$gbid";
		$conditions .= $can_moderate ? '' : " AND gbm_options&$mod=0"; 

//		$orderby = $nested ? 'gbm_replyto ASC, gbm_date ASC' : 'gbm_date ASC';
		$orderby = 'gbm_date ASC';
		
		$msgs = GDO::table('GWF_GuestbookMSG');
		$ipp = $module->cfgItemsPerPage();
		$nItems = $msgs->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', $nPages)), 1, $nPages);
		
		$gbid_app = $gbid === 1 ? '' : '/'.$gbid; # append

		$tVars = array(
			'gb' => $gb,
			'entries' => $msgs->selectObjects('*', $conditions, $orderby, $ipp, GWF_PageMenu::getFrom($page, $ipp)),
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'guestbook/show'.$gbid_app.'/page-%PAGE%'),
			'href_sign' => GWF_WEB_ROOT.'guestbook/sign/'.$gbid,
			'href_moderate' => GWF_WEB_ROOT.'guestbook/edit/'.$gbid,
			'can_moderate' => $can_moderate, 
		);
		
		$filename = 'show.php';
//		$filename = $nested ? 'show_nested.php' : 'show.php';
		
		return $module->templatePHP($filename, $tVars);
	}

	public function templateNested(Module_Guestbook $module, GWF_Guestbook $gb)
	{
		$gbid = $gb->getID();
		$ipp = $module->cfgItemsPerPage();
		$user = GWF_Session::getUser();
		$can_moderate = $gb->canModerate($user);
		$mod = GWF_GuestbookMSG::IN_MODERATION;
		$msgs = GDO::table('GWF_GuestbookMSG');
		$conditions = "gbm_gbid=$gbid AND gbm_replyto=0";
		$conditions .= $can_moderate ? '' : " AND gbm_options&$mod=0"; 
		$nItems = $msgs->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', $nPages)), 1, $nPages);
		$gbid_app = $gbid === 1 ? '' : '/'.$gbid; # append
		$orderby = 'gbm_date ASC';
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$tVars = array(
			'gb' => $gb,
			'entries' => $this->getNestedEntries($module, $gb, $msgs, $conditions, $ipp, $from),
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'guestbook/show'.$gbid_app.'/page-%PAGE%'),
			'href_sign' => GWF_WEB_ROOT.'guestbook/sign/'.$gbid,
			'href_moderate' => GWF_WEB_ROOT.'guestbook/edit/'.$gbid,
			'can_moderate' => $can_moderate, 
		);
		
		return $module->templatePHP('show_nested.php', $tVars);
	}
	
	private function getNestedEntries(Module_Guestbook $module, GWF_Guestbook $gb, GWF_GuestbookMSG $msgs, $conditions, $ipp, $from)
	{
		$entries = $msgs->selectObjects('*', $conditions, 'gbm_date ASC', $ipp, $from);
		foreach ($entries as $entry)
		{
			$this->getNestedEntriesR($entry);
		}
		return $entries;
	}

	private function getNestedEntriesR(GWF_GuestbookMSG &$entry)
	{
		$pid = $entry->getVar('gbm_id');
		$childs = $entry->selectObjects('*', "gbm_replyto=$pid", 'gbm_date ASC');
		$entry->setVar('childs', $childs);
		foreach ($childs as $child)
		{
			$this->getNestedEntriesR($child);
		}
	}
}

?>
