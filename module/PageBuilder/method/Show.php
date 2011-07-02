<?php
/**
 * Show a page.
 * @author gizmore
 */
final class PageBuilder_Show extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		require_once 'module/PageBuilder/GWF_Page.php';
		$pages = GDO::table('GWF_Page')->selectAll('page_id, page_url', 'page_options&1', '', NULL, -1, -1, GDO::ARRAY_N);
		$back = '';
		foreach ($pages as $page)
		{
			$url = $this->replaceRewriteURL($page[1]);
			$back .= "RewriteRule ^{$url}/?$ index.php?mo=PageBuilder&me=Show&pageid={$page[0]}".PHP_EOL;
		}
		return $back;
	}
	
	private function replaceRewriteURL($url)
	{
		$search = array(   '.',   '*',   '[',   ']',   '?',   '+',   '{',   '}',   '^',   '$');
		$replace = array('\\.', '\\*', '\\[', '\\]', '\\?', '\\+', '\\{', '\\}', '\\^', '\\$');
		return str_replace($search, $replace, $url);
	}

	private $mod_c = false;
	private $comments = NULL;
	
	public function execute(Module_PageBuilder $module)
	{
		# Page exists?
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid'))))
		{
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
			return $module->error('err_404');
		}
		
		# Have permission to see?
		if (!$this->checkPermission($module, $page))
		{
			header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		# Load comments?
		if ($page->isOptionEnabled(GWF_Page::COMMENTS))
		{
			$this->mod_c = GWF_Module::loadModuleDB('Comments', true, true);
			$this->comments = $page->getComments();
			$_REQUEST['cmts_id'] = $this->comments->getID();
			
		}
		
		# Exec ...
		$back = '';

		if (isset($_POST['reply']))
		{
			$back = $this->onReply($module, $page);
		}
		
		return $this->showPage($module, $page) . $back;
	}
	
	private function checkPermission(Module_PageBuilder $module, GWF_Page $page)
	{
		$user = GWF_Session::getUser();
		if ($page->isLoginRequired() && ($user === false)) {
			return false;
		}
		$gids = explode(',', $page->getVar('page_groups'));
		foreach ($gids as $i => $gid) {
			if ($gid === '' || $gid === '0') {
				unset($gids[$i]);
			}
		}
		if (count($gids) === 0) { return true; }
		if ($user === false) { return false; }
		foreach($gids as $gid)
		{
			if ($user->isInGroupID($gid))
			{
				return true;
			}
		}
		return false;
	}
	
	private function showPageOLD(Module_PageBuilder $module, GWF_Page $page)
	{
		$page->increase('page_views', 1);
		
		GWF_Website::setMetaDescr($page->getVar('page_meta_desc'));
		GWF_Website::setMetaTags($page->getVar('page_meta_tags'));
		GWF_Website::setPageTitle($page->getVar('page_title'));
		
		$smarty = GWF_Template::getSmarty();
		$smarty->assign('user', GWF_User::getStaticOrGuest()); // TODO: not required anymore?!
		
		ob_start();
		$smarty->display('db:'.$page->getID());
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}

	private function showPage(Module_PageBuilder $module, GWF_Page $page)
	{
		$page->increase('page_views', 1);
		
		GWF_Website::setMetaDescr($page->getVar('page_meta_desc'));
		GWF_Website::setMetaTags($page->getVar('page_meta_tags'));
		GWF_Website::setPageTitle($page->getVar('page_title'));
		
		$tVars = array(
			'title' => $page->display('page_title'),
			'author' => $page->display('page_author_name'),
			'created' => GWF_Time::displayDate($page->getVar('page_create_date')),
			'modified' => GWF_Time::displayDate($page->getVar('page_date')),
			'content' => $this->getPageContent($module, $page),
			'comments' => $this->getPageComments($module, $page),
			'form_reply' => $this->getPageCommentsForm($module, $page),
			'pagemenu' => $this->getPagemenuComments($module, $page),
			'translations' => $this->getPageTranslations($module, $page),
			'similar' => $this->getSimilarPages($module, $page),
		);
		return $module->template('show_page.tpl', $tVars);
	}

	private function getPageContent(Module_PageBuilder $module, GWF_Page $page)
	{
		switch ($page->getMode())
		{
			case GWF_Page::HTML: return $page->getVar('page_content');
			case GWF_Page::BBCODE: return GWF_Message::display($page->getVar('page_content'));
			case GWF_Page::SMARTY: return $this->getPageContentSmarty($module, $page);
			default: return 'ERROR 0915';
		}
	}
	
	private function getPageContentSmarty(Module_PageBuilder $module, GWF_Page $page)
	{
		$smarty = GWF_Template::getSmarty();
//		$smarty->assign('user', GWF_User::getStaticOrGuest());
		return $smarty->fetch('db:'.$page->getID());
	}

	private function getPageComments(Module_PageBuilder $module, GWF_Page $thePage)
	{
		if ($this->comments === NULL)
		{
			return '';
		}
		$comments = $this->comments;
		
		$ipp = $module->cfgCommentsPerPage();
		$cid = $comments->getID();
		$visible = GWF_Comment::VISIBLE;
		$where = "cmt_cid={$cid} AND cmt_options&{$visible}";
		$comment = GDO::table('GWF_Comment');
		$nItems = $comment->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('cpage'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);

		$c = $comment->selectObjects('*', $where, 'cmt_date ASC', $ipp, $from);
		
		$href = $this->getMethodHREF('&pageid='.$thePage->getID());
		
		return $comments->displayComments($c, $href);
	}
	
	private function getPagemenuComments(Module_PageBuilder $module, GWF_Page $thePage)
	{
		if ($this->comments === NULL)
		{
			return '';
		}
		$comments = $this->comments;
		$ipp = $module->cfgCommentsPerPage();
		$cid = $comments->getID();
		$visible = GWF_Comment::VISIBLE;
		$where = "cmt_cid={$cid} AND cmt_options&{$visible}";
		$comment = GDO::table('GWF_Comment');
		$nItems = $comment->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('cpage'), 1, $nPages);
//		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$href = $this->getMethodHREF('&pageid='.$thePage->getID().'&cpage=%PAGE%');
		
		return GWF_PageMenu::display($page, $nPages, $href);
	}
	
	private function getSimilarPages(Module_PageBuilder $module, GWF_Page $page)
	{
		if (!$page->isOptionEnabled(GWF_Page::SHOW_SIMILAR))
		{
			return array();
		}
		
		return array();
	}
	
	private function getPageTranslations(Module_PageBuilder $module, GWF_Page $page)
	{
		if (!$page->isOptionEnabled(GWF_Page::SHOW_TRANS))
		{
			return array();
		}
		
		$pid = $page->getID();
		$where = "page_otherid={$pid} AND page_id!={$pid}";
		
		if (false === ($result = $page->selectAll('page_title title, page_url url, page_lang langid', $where, 'page_lang ASC', NULL, -1, -1, GDO::ARRAY_N)))
		{
			return array();
		}
		
		return $result;
	}
	
	private function onReply(Module_PageBuilder $module, GWF_Page $page)
	{
		$reply = $this->mod_c->getMethod('Reply');
		$reply instanceof Comments_Reply;
		$href = $this->getMethodHREF('&pageid='.$page->getID());
		return $reply->onReply($this->mod_c, $href);
	}

	private function getPageCommentsForm(Module_PageBuilder $module, GWF_Page $page)
	{
		if (isset($_POST['reply']))
		{
			return '';
		}
		$reply = $this->mod_c->getMethod('Reply');
		$reply instanceof Comments_Reply;
		$href = $this->getMethodHREF('&pageid='.$page->getID());
		return $reply->templateReply($this->mod_c, $href);
	}
}
?>