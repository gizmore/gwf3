<?php

final class Links_Overview extends GWF_Method
{
	const DEFAULT_BY = 'vs_sum';
	const DEFAULT_DIR = 'DESC';
//	const DEFAULT_ORDERBY = '';
	
	public function getHTAccess()
	{
		return 
			'RewriteRule ^links$ index.php?mo=Links&me=Overview'.PHP_EOL.
			'RewriteRule ^links/([^/]+)$ index.php?mo=Links&me=Overview&tag=$1'.PHP_EOL.
			'RewriteRule ^links/([^/]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Links&me=Overview&tag=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'RewriteRule ^links/([^/]+)/by/page-(\d+)$ index.php?mo=Links&me=Overview&tag=$1&page=$2'.PHP_EOL.
			'RewriteRule ^links/by/page-(\d+)$ index.php?mo=Links&me=Overview&page=$1'.PHP_EOL.
			'RewriteRule ^links/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Links&me=Overview&by=$1&dir=$2&page=$3'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Module::loadModuleDB('Votes')->onInclude();
		
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}

		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Links/gwf_links.js');
		
		return $this->overview();
	}
	
	private $user;
	private $by;
	private $dir;
	private $orderby;
	private $tag;
	private $lpp;
	private $nLinks;
	private $nPages;
	private $page;
	private $from;
	private $sortURL;
	private $links;
	private $pagemenu;
	private $hrefAdd;
	private $add_link_text;
	
	private function sanitize()
	{
		$this->user = GWF_Session::getUser();
		$links = GDO::table('GWF_Links');
				
		$this->by = Common::getGet('by', self::DEFAULT_BY);
		$this->dir = Common::getGet('dir', self::DEFAULT_DIR);
		
//		if ($this->by === false && $this->dir === false)
//		{
//			$this->by = self::DEFAULT_BY;
//			$this->dir = self::DEFAULT_DIR;
//			$this->orderby = self::DEFAULT_ORDERBY;
//		}
//		else
//		{
			$this->orderby = $links->getMultiOrderby($this->by, $this->dir);
//		}
		
		$this->tag = GWF_LinksTag::getWhitelistedTag(Common::getGet('tag'), '');
		
		$this->lpp = $this->module->cfgLinksPerPage();
		$this->nLinks = $links->countLinks($this->module, $this->user, $this->tag, false);
		$this->nPages = GWF_PageMenu::getPagecount($this->lpp, $this->nLinks);
		$this->page = Common::clamp(Common::getGet('page', 1), 1, $this->nPages);
		$this->from = GWF_PageMenu::getFrom($this->page, $this->lpp);
		
		if ($this->tag === '') {
			$this->sortURL = GWF_WEB_ROOT.'links/by/%BY%/%DIR%/page-1';
			$href = GWF_WEB_ROOT.'links/by/'.$this->by.'/'.$this->dir.'/page-%PAGE%';
		} else {
			$this->sortURL = GWF_WEB_ROOT.'links/'.$this->tag.'/by/%BY%/%DIR%/page-1';
			$href = GWF_WEB_ROOT.'links/'.Common::urlencodeSEO($this->tag).'/by/'.$this->by.'/'.$this->dir.'/page-%PAGE%';
		}
		
//		var_dump($this->tag);
		
//		$unread_query = $this->module->getUnreadQuery($this->user);
		$tag_query = $links->getTagQuery($this->tag);
		
//		var_dump($tag_query);
		
		if ($this->module->cfgShowPermitted()) {
			$conditions = "($tag_query)";
		}
		else {
			$perm_query = $this->module->getPermQuery($this->user);
			$mod_query = $links->getModQuery($this->user);
			$member_query = $links->getMemberQuery($this->user);
			$private_query = $links->getPrivateQuery($this->user);
			$conditions = "($perm_query) AND ($tag_query) AND ($mod_query) AND ($member_query) AND ($private_query)";# AND (NOT $unread_query))";
		}		

//		var_dump($conditions);
		
		if (false === ($this->links = $links->selectObjects('*', $conditions, $this->orderby, $this->lpp, $this->from))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$this->pagemenu = GWF_PageMenu::display($this->page, $this->nPages, $href);
		
		$this->add_link_text = GWF_LinksValidator::mayAddLink($this->module, $this->user);
		$this->hrefAdd = $this->add_link_text === false ? $this->module->getMethodURL('Add', '&tag='.$this->tag) : false;
		
		
//		$this->newLinks = $links->select("(($perm_query) AND ($unread_query) AND ($mod_query) AND ($member_query) AND ($tag_query))", 'link_date ASC');

		return false;
	}
	
	private function overview()
	{
		if ($this->tag === '') {
			$tag_title = $this->module->lang('pt_links');
			GWF_Website::setPageTitle($this->module->lang('pt_links'));
			GWF_Website::setMetaTags($this->module->lang('mt_links'));
			GWF_Website::setMetaDescr($this->module->lang('md_links'));
		}
		else {
			$dtag = GWF_HTML::display($this->tag);
			$tag_title = $this->module->lang('pt_linksec', array( $dtag));
			GWF_Website::setPageTitle($this->module->lang('pt_linksec', array( $dtag)));
			GWF_Website::setMetaTags($this->module->lang('mt_linksec', array( $dtag)));
			GWF_Website::setMetaDescr($this->module->lang('md_linksec', array( $dtag)));
		}
		
		$with_votes = GWF_Session::isLoggedIn() ? true : $this->module->cfgGuestVotes();
//		$sortURLNew = $this->module->getMethodURL('NewLinks', '&by=%BY%&dir=%DIR%&page=1');
		$tVars = array(
			'cloud' => $this->module->templateCloud(),
			'search' => '', #$this->module->templateSearch(),
			'new_link_count' => $this->module->countUnread(GWF_Session::getUser()),
			'links' => $this->module->templateLinks($this->links, $this->sortURL, $this->by, $this->dir, false, false, false, $with_votes),
			'page_menu' => $this->pagemenu,
			'href_add' => $this->hrefAdd,
			'href_search' => GWF_WEB_ROOT.'link/search',
			'href_new_links' => GWF_WEB_ROOT.'index.php?mo=Links&me=NewLinks',
			'href_mark_read' => GWF_WEB_ROOT.'index.php?mo=Links&me=NewLinks&markread=all',
			'may_add_link' => $this->hrefAdd !== false,
			'tag_title' => $tag_title,
			'text_add' => $this->add_link_text,
		);
		return $this->module->templatePHP('overview.php', $tVars);
	}
}

?>