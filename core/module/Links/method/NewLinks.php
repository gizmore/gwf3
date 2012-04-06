<?php
/**
 * Show new links and mark them read.
 * @author gizmore
 */
final class Links_NewLinks extends GWF_Method
{
	const DEFAULT_BY = 'link_date';
	const DEFAULT_DIR = 'ASC';
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Links&me=NewLinks',
						'page_title' => 'New Links',
						'page_meta_desc' => 'Browse the newest links and mark them as read',
				),
		);
	}
	
	public function execute()
	{
		GWF_Website::setPageTitle($this->module->lang('pt_new_links'));
		GWF_Website::setMetaTags($this->module->lang('mt_new_links'));
		
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Links/gwf_links.js');
		
		if (Common::getGet('markread') !== false) {
			return $this->onMarkAllRead().$this->templateNewLinks();
		}
		
		return $this->templateNewLinks();
	}
	
	private function templateNewLinks()
	{
		$user = GWF_Session::getUser();
		$links = GDO::table('GWF_Links');
		$by = Common::getGet('by', self::DEFAULT_BY);
		$dir = Common::getGet('dir', self::DEFAULT_DIR);
		$orderby = $links->getMultiOrderby($by, $dir);
		$ipp = $this->module->cfgLinksPerPage();
		$nItems = $this->module->countUnread($user);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page')), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$pmhref = GWF_WEB_ROOT.'';
		$conditions = $this->module->getUnreadConditions($user);
		$new_links = $links->selectObjects('*', $conditions, $orderby, $ipp, $from);
		$sortURL = GWF_WEB_ROOT.'index.php?mo=Links&amp;me=NewLinks&amp;by=%BY%&amp;dir=%DIR%&amp;page=1';
		$with_votes = GWF_Session::isLoggedIn() ? true : $this->module->cfgGuestVotes();
		$tVars = array(
			'cloud' => $this->module->templateCloud(),
			'page_menu' => GWF_PageMenu::display($page, $nPages, $pmhref),
			'new_links' => $this->module->templateLinks($new_links, $sortURL, $by, $dir, false, false, false, $with_votes),
		);
		return $this->module->templatePHP('new_links.php', $tVars);
	}
	
	private function onMarkAllRead()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return '';
		}
		
		$table = GWF_Links::table('GWF_Links');
		
		if (false === ($result = $table->select('*'))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		while (false !== ($link = $table->fetch($result, GDO::ARRAY_O)))
		{
			$link instanceof GWF_Links;
			if (false === $link->markRead($user)) {
				$table->free($result);
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		$table->free($result);
		
		$data = $user->getUserData();
		$data[Module_Links::USERDATA_MARK] = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		if (false === $user->saveUserData($data)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->module->message('msg_marked_all_read');
	}
}
?>