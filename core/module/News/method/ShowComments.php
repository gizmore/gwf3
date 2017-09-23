<?php
final class News_ShowComments extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^news-comments-(\\d+)-[^/]+-page-(\\d+)\\.html$ index.php?mo=News&me=ShowComments&newsid=$1&cpage=$2'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($mod_c = GWF_Module::loadModuleDB('Comments', true, true)))
		{
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Comments'));
		}
		
		if (false === ($news = GWF_News::getByID(Common::getGetString('newsid'))))
		{
			return $this->module->error('err_news');
		}
		
		$key = $news->getCommentsKey();
		$gid = GWF_Group::getByName(GWF_Group::MODERATOR)->getID();
		if (false === ($comments = GWF_Comments::getOrCreateComments($key, 0, $gid)))
		{
			return $this->module->error('err_news');
		}
		
		$_REQUEST['cmts_id'] = $comments->getID();
		
		$back = '';
		if (isset($_POST['reply']))
		{
			return $this->onReply($mod_c, $news, $comments);
		}
		
		return $back . $this->templateComments($mod_c, $news, $comments);
	}
	
	public function templateComments(Module_Comments $mod_c, GWF_News $news, GWF_Comments $comments)
	{
		$ipp = 10;
		$cid = $comments->getID();
		
		// Method
		$me = $mod_c->getMethod('Reply');
		$me instanceof Comments_Reply;
		
		$where = "cmt_cid={$cid}";

		if ( GWF_User::isInGroupS('moderator') )
		{
			$flag_mask = GWF_Comment::DELETED;
			$wanted_flags = 0;
		} else {
			$flag_mask = GWF_Comment::VISIBLE | GWF_Comment::DELETED;
			$wanted_flags = GWF_Comment::VISIBLE;
		}
		$where .= " AND cmt_options & {$flag_mask} = {$wanted_flags}";
		
		$nItems = GDO::table('GWF_Comment')->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('cpage'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$c = GDO::table('GWF_Comment')->selectObjects('*', $where, 'cmt_date ASC', $ipp, $from);
		
		$href = GWF_WEB_ROOT.'news-comments-'.$news->getID().'-'.$news->displayTitle().'-page-'.$page.'.html';
		$hrefp = GWF_WEB_ROOT.'news-comments-'.$news->getID().'-'.$news->displayTitle().'-page-%PAGE%.html';
		$tVars = array(
			'news' => $news,
			'newsitem' => Module_News::displayBoxB(array($news)),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $hrefp),
			'comments' => $comments->displayComments($c, $href),
			'form' => $me->templateReply($href),
		);
		return $this->module->template('comments.tpl', $tVars);
	}
	
	private function onReply(Module_Comments $mod_c, GWF_News $news, GWF_Comments $comments)
	{
		$ipp = 10;
		$nItems = $comments->getVar('cmts_count');
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('cpage'), 1, $nPages);
		$href = GWF_WEB_ROOT.'news-comments-'.$news->getID().'-'.$news->displayTitle().'-page-'.$page.'.html';
		
		$me = $mod_c->getMethod('Reply');
		$me instanceof Comments_Reply;
		return $me->onReply($href);
	}
}
?>
