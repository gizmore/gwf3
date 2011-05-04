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
			$back .= "RewriteRule ^{$url}/?$ index.php?mo=PageBuilder&me=Show&page={$page[0]}".PHP_EOL;
		}
		return $back;
	}
	
	private function replaceRewriteURL($url)
	{
		$search = array(   '.',   '*',   '[',   ']',   '?',   '+',   '{',   '}',   '^',   '$');
		$replace = array('\\.', '\\*', '\\[', '\\]', '\\?', '\\+', '\\{', '\\}', '\\^', '\\$');
		return str_replace($search, $replace, $url);
	}

	
	public function execute(Module_PageBuilder $module)
	{
		if (false === ($page = GWF_Page::getByID(Common::getGetString('page')))) {
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
			return $module->error('err_404');
		}
		
		if (!$this->checkPermission($module, $page)) {
			header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return $this->showPage($module, $page);
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
	
	private function showPage(Module_PageBuilder $module, GWF_Page $page)
	{
		GWF_Website::setMetaDescr($page->getVar('page_meta_desc'));
		GWF_Website::setMetaTags($page->getVar('page_meta_tags'));
		GWF_Website::setPageTitle($page->getVar('page_title'));
		
		$smarty = GWF_Template::getSmarty();
		$smarty->assign('user', GWF_User::getStaticOrGuest());
		
		ob_start();
		$smarty->display('db:'.$page->getID());
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}
}
?>