<?php
/**
 * Show a page.
 * @author gizmore
 */
final class PageBuilder_Show extends GWF_Method
{
	public function getHTAccess()
	{
		require_once GWF_CORE_PATH.'module/PageBuilder/GWF_Page.php';
		require_once GWF_CORE_PATH.'module/PageBuilder/GWF_PB_Rewrites.php';
		$pages = GDO::table('GWF_Page')->selectAll('page_id, page_url', 'page_options&1', '', NULL, -1, -1, GDO::ARRAY_N);
		$back = '';

		if (0 !== ($hpid = $this->_module->cfgHomePage()))
		{
			$back .= "RewriteRule ^$ index.php?mo=PageBuilder&me=Show&pageid={$hpid}".PHP_EOL;
		}

		foreach ($pages as $page)
		{
			$url = GWF_PB_Rewrites::replaceRewriteURL($page[1]);
			$back .= "RewriteRule ^{$url}/?$ index.php?mo=PageBuilder&me=Show&pageid={$page[0]}".PHP_EOL;
		}
		return $back;
	}

	private $mod_c = false;
	private $comments = NULL;
	
	public function execute()
	{
		# Page exists?
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid'))))
		{
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
			return $this->_module->error('err_404');
		}
		
		# Have permission to see?
		if (!$this->checkPermission($page))
		{
			header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		# Load comments?
		if ($page->isOptionEnabled(GWF_Page::COMMENTS))
		{
			$this->mod_c = GWF_Module::loadModuleDB('Comments', true, true);
			if (false === ($this->comments = $page->getComments()))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			$_REQUEST['cmts_id'] = $this->comments->getID();
			
		}
		
		# Exec ...
		$back = '';

		if (isset($_POST['reply']))
		{
			$back = $this->onReply($page);
		}
		
		return $this->showPage($page) . $back;
	}
	
	private function checkPermission(GWF_Page $page)
	{
		if ('' === ($groups = $page->getVar('page_groups')))
		{
			return true;
		}
		
		if (false === ($user = GWF_Session::getUser()) && $page->isLoginRequired())
		{
			return false;
		}

		$gids = explode(',', $groups);
		foreach ($gids as $i => $gid)
		{
			if ($user->isInGroupID($gid)) 
			{
				return true;
			}
			elseif($gid === '' || $gid === '0')
			{
				unset($gids[$i]);
			}
		}
		if (count($gids) === 0) { return true; }
		return false;
	}
	
	private function showPageOLD(GWF_Page $page)
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

	private function showPage(GWF_Page $page)
	{
		$page->increase('page_views', 1);
		
		$robot = ($page->isOptionEnabled(GWF_PAGE::INDEX)) ? 'index,' : 'noindex,';
		$robot .= ($page->isOptionEnabled(GWF_PAGE::FOLLOW)) ? 'follow' : 'nofollow';
		GWF_Website::addMeta(array('robots', $robot, 0), true);
		GWF_Website::setMetaDescr($page->getVar('page_meta_desc'));
		GWF_Website::setMetaTags($page->getVar('page_meta_tags'));
		GWF_Website::setPageTitle($page->getVar('page_title'));
		GWF_Website::addInlineCSS($page->getVar('page_inline_css'));
		
		$tVars = array(
			'page' => $page,
			'page_views' => $page->getVar('page_views'),
 			'title' => $page->display('page_title'),
			'author' => $page->display('page_author_name'),
			'created' => GWF_Time::displayDate($page->getVar('page_create_date')),
			'modified' => GWF_Time::displayDate($page->getVar('page_date')),
			'content' => $this->getPageContent($page),
			'comments' => $this->getPageComments($page),
			'form_reply' => $this->getPageCommentsForm($page),
			'pagemenu' => $this->getPagemenuComments($page),
			'translations' => $this->getPageTranslations($page),
			'similar' => $this->getSimilarPages($page),
		);
		return $this->_module->template('show_page.tpl', $tVars);
	}

	private function getPageContent(GWF_Page $page)
	{
		switch ($page->getMode())
		{
			case GWF_Page::HTML: return $page->getVar('page_content');
			case GWF_Page::BBCODE: return GWF_Message::display($page->getVar('page_content'));
			case GWF_Page::SMARTY: return $this->getPageContentSmarty($page);
			default: return 'ERROR 0915';
		}
	}
	
	private function getPageContentSmarty(GWF_Page $page)
	{
		$smarty = GWF_Template::getSmarty();
//		$smarty->assign('user', GWF_User::getStaticOrGuest());
		return $smarty->fetch('db:'.$page->getID());
	}

	private function getPageComments(GWF_Page $thePage)
	{
		if ($this->comments === NULL)
		{
			return '';
		}
		$comments = $this->comments;
		
		$ipp = $this->_module->cfgCommentsPerPage();
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
	
	private function getPagemenuComments(GWF_Page $thePage)
	{
		if ($this->comments === NULL)
		{
			return '';
		}
		$comments = $this->comments;
		$ipp = $this->_module->cfgCommentsPerPage();
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
	
	private function getSimilarPages(GWF_Page $page)
	{
		if (!$page->isOptionEnabled(GWF_Page::SHOW_SIMILAR))
		{
			return array();
		}
		
		return array();
	}
	
	private function getPageTranslations(GWF_Page $page)
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
	
	private function onReply(GWF_Page $page)
	{
		$reply = $this->mod_c->getMethod('Reply');
		$reply instanceof Comments_Reply;
		$href = $this->getMethodHREF('&pageid='.$page->getID());
		return $reply->onReply($href);
	}

	private function getPageCommentsForm(GWF_Page $page)
	{
		if (isset($_POST['reply']) || !$page->isOptionEnabled(GWF_Page::COMMENTS))
		{
			return '';
		}
		$reply = $this->mod_c->getMethod('Reply');
		$reply instanceof Comments_Reply;
		$href = $this->getMethodHREF('&pageid='.$page->getID());
		return $reply->templateReply($href);
	}
}
?>
