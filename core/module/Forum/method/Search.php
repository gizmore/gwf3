<?php
/**
 * Forum Search
 * @since 2.0
 * @version 3.0
 * @todo Advanced Search
 * @author gizmore
 */
final class Forum_Search extends GWF_Method
{
	public function getPageMenuLinks()
	{
		return array(
			array(
					'page_url' => 'index.php?mo=Forum&me=Search',
					'page_title' => 'Forum Search',
					'page_meta_desc' => 'Quick search through the forum',
			),
		);
	}
	
	public function execute()
	{
		$this->pagemenu = '';
		$this->sortURL = '';
		if (false !== Common::getPost('qsearch')) {
			return $this->onQuickSearch(Common::getPost('term'));
		}
		if (false !== ($term = Common::getGet('term'))) {
			return $this->onQuickSearch($term);
		}
		return $this->templateSearch();
	}

	#############
	### Forms ###
	#############
//	public function getFormAdv()
//	{
//		return GWF_FormGDO::getSearchForm($this->module, $this, GDO::table('GWF_ForumPost'), GWF_User::getStaticOrGuest(), true);
//	}
	
	public function getFormQuick()
	{
		return GWF_QuickSearch::getQuickSearchForm($this->module, $this);
	}
	
	public function templateSearch($result=array(), $term='')
	{
		$tVars = array(
			'form_quick' => $this->getFormQuick()->templateX($this->module->lang('ft_search_quick'), false),
//			'form_adv' => $this->getFormAdv()->templateY($this->module->lang('ft_search_adv')),
			'pagemenu' => $this->pagemenu,
			'sort_url' => $this->sortURL,
			'result' => $result,
			'term' => $term,
		);
		return $this->module->templatePHP('search.php', $tVars);
	}
	
	##############
	### Search ###
	##############
	public function onQuickSearch($term)
	{
		$posts = GDO::table('GWF_ForumPost');
		$fields = $posts->getSearchableFields(GWF_User::getStaticOrGuest());
		$_GET['term'] = $term = trim($term);
//		$term = Common::getRequest('term', '');
		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($posts, $fields, $term)))
		{
			$conditions = '0';
		}
		
		$permQuery = GWF_ForumPost::getPermQuery();
		$conditions .= ' AND ('.$permQuery.')';
		$by = Common::getGet('by', 'post_date');
		$dir = Common::getGet('dir', 'DESC');
		$orderby = $posts->getMultiOrderby($by, $dir);
		$ipp = $this->module->getThreadsPerPage();
		$nItems = $posts->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGet('page', 1), 1, $nPages);
		$href = $this->getMethodHref(sprintf('&term=%s&by=%s&dir=%s&page=%%PAGE%%', urlencode($term), urlencode($by), urlencode($dir)));
		$this->pagemenu = GWF_PageMenu::display($page, $nPages, $href);
		$result = GWF_QuickSearch::search($posts, $fields, $term, $orderby, $ipp, GWF_PageMenu::getFrom($page, $ipp), $permQuery);
		$this->sortURL = $this->getMethodHref(sprintf('&term=%s&by=%%BY%%&dir=%%DIR%%&page=1', urlencode($term)));
		return $this->templateSearch($result, $term);
	}
}

?>
