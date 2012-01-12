<?php
/**
 * Site Table Overview.
 * @author gizmore
 */
final class WeChall_Sites extends GWF_Method
{
	private $pageTitle = '';
	
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^sites.php$ index.php?mo=WeChall&me=Sites&which=1&langiso=all'.PHP_EOL.
			'RewriteRule ^active_sites$ index.php?mo=WeChall&me=Sites&which=1&langiso=all'.PHP_EOL.
			'RewriteRule ^active_sites/([a-z]{2,3})/by/page-(\d+)$ index.php?mo=WeChall&me=Sites&which=1&langiso=$1&page=$2'.PHP_EOL.
			'RewriteRule ^active_sites/([a-z]{2,3})/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Sites&langiso=$1&which=1&by=$2&dir=$3&page=$4'.PHP_EOL.
			
			'RewriteRule ^all_sites$ index.php?mo=WeChall&me=Sites&which=5'.PHP_EOL.
			'RewriteRule ^all_sites/by/([^/]+)/([DEASC,]+)/?$ index.php?mo=WeChall&me=Sites&which=5&by=$1&dir=$2&page=1'.PHP_EOL.
			'RewriteRule ^all_sites/(\d+)-([^/]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Sites&which=5&tag=$2&page=$3'.PHP_EOL.
			'RewriteRule ^all_sites/(\d+)-([^/]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Sites&tag=$2&which=5&by=$3&dir=$4&page=$5'.PHP_EOL.
			'RewriteRule ^all_sites/([a-z]{2})$ index.php?mo=WeChall&me=Sites&which=5&langiso=$1'.PHP_EOL.
			'RewriteRule ^all_sites/([a-z]{2})/by/page-(\d+)$ index.php?mo=WeChall&me=Sites&which=5&langiso=$1&page=$2'.PHP_EOL.
			'RewriteRule ^all_sites/([a-z]{2})/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Sites&langiso=$1&which=5&by=$2&dir=$3&page=$4'.PHP_EOL.
		
			'RewriteRule ^graveyard$ index.php?mo=WeChall&me=Sites&which=2&langiso=all'.PHP_EOL.
			'RewriteRule ^graveyard/by/([^/]+)/([DEASC,]+)$ index.php?mo=WeChall&me=Sites&which=2&langiso=all'.PHP_EOL.
		
			'RewriteRule ^not_ranked$ index.php?mo=WeChall&me=Sites&which=4&langiso=all'.PHP_EOL.
			'RewriteRule ^not_ranked/by/([^/]+)/([DEASC,]+)/?$ index.php?mo=WeChall&me=Sites&which=4&by=$1&dir=$2&page=1&langiso=all'.PHP_EOL.
			
			'RewriteRule ^coming_soon$ index.php?mo=WeChall&me=Sites&which=3&langiso=all'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		WC_HTML::$LEFT_PANEL = false;
		WC_HTML::$RIGHT_PANEL = false;
		return $this->templateSites($this->_module);
	}
	
	private function templateSites()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteAdmin.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteCats.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteDescr.php';
		
		$tag = Common::getGet('tag', '');
		if (0 === ($tag_bit = WC_SiteCats::getBitForCat($tag))) {
			$tag = '';
		}
		
		$this->setPageDescription($this->_module, $tag);
		
		$status_query = $this->getStatusQuery();
		$lang_query = $this->getLangQuery();
		$tag_query = $this->getTagQuery($tag_bit);
		
		$ipp = $this->_module->cfgItemsPerPage();
		
		$by = Common::getGet('by', 'site_id');
		$dir = Common::getGet('dir', 'DESC');
		$page = intval(Common::getGet('page', 1));
		
		$table = GDO::table('WC_Site');
		
		$orderby = $table->getMultiOrderby($by, $dir);
		$conditions = "($status_query) AND ($lang_query) AND ($tag_query)";
		$nItems = $table->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp($page, 1, $nPages);
		
		$href = $this->getPageMenuHREF();
		
		$tVars = array(
			'sites' => $table->selectObjects('*', $conditions, $orderby, $ipp, GWF_PageMenu::getFrom($page, $ipp)),
			'descrs' => WC_SiteDescr::getAllDescr(),
			'site_quickjump' => $this->_module->templateSiteQuickjumpDetail(),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href),
			'sortURL' => $this->getTableSortURL(),
			'which' => intval(Common::getGet('which')),
			'tag' => $tag,
			'page_title' => $this->pageTitle,
		);
		return $this->_module->templatePHP('sites.php', $tVars);
	}
	
	private function getWhich()
	{
		return Common::clamp(intval(Common::getGetInt('which', 1)), 1, 5);
	}
	
	private function setPageDescription(Module_WeChall $module, $tag)
	{
		$which = (string) $this->getWhich();
		if ($tag !== '') {
			$tag = " $tag ";
		}
		
		if ($tag !== '') {
			$this->pageTitle = $this->_module->lang('pt_sites_'.$which.'_tagged', array($tag));
		}
		else {
			$this->pageTitle = $this->_module->lang('pt_sites_'.$which);
		}
		GWF_Website::setPageTitle($this->pageTitle);
		GWF_Website::setMetaDescr($this->_module->lang('md_sites_'.$which));
		GWF_Website::setMetaTags($this->_module->lang('mt_sites_'.$which));
	}
	
	private function getStatusQuery()
	{
		switch($this->getWhich())
		{
			case 1: return 'site_status=\'up\' OR site_status=\'down\'';
			case 2: return 'site_status=\'dead\'';
			case 3: return 'site_status=\'wanted\' OR site_status=\'contacted\' OR site_status=\'coming_soon\'';
			case 4: return 'site_status=\'refused\'';
			case 5: return '1';
			default: die('Unknown status in WeChall/method/Sites::getStatusQuery()');
		}
	}
	
	private function getLangQuery()
	{
		if ('all' === ($iso = trim(Common::getGetString('langiso', 'all')))) {
			return '1';
		}
		
		if (false === ($lang = GWF_Language::getByISO($iso)))
		{
			return '1';
		}
		$langid = $lang->getID();
		return "site_language='$langid'";
	}
	
	private function getTableSortURL()
	{
		switch(intval(Common::getGet('which')))
		{
			case 2: return GWF_WEB_ROOT.'graveyard/by/%BY%/%DIR%';
			case 3: return GWF_WEB_ROOT.'coming_soon/by/%BY%/%DIR%';
			case 4: return GWF_WEB_ROOT.'not_ranked/by/%BY%/%DIR%';
			case 5: return GWF_WEB_ROOT.'all_sites/by/%BY%/%DIR%';
			default: return GWF_WEB_ROOT.'active_sites/'.Common::getGet('langiso').'/by/%BY%/%DIR%/page-1';
		}
	}

	private function getPageMenuHREF()
	{
		switch(intval(Common::getGet('which')))
		{
			case 1:
				return GWF_WEB_ROOT.sprintf('active_sites/%s/by/%s/%s/page-%%PAGE%%', Common::getGet('langiso'), Common::getGet('by'), Common::getGet('dir'));
			default: return '';
		}
	}
	
	private function getTagQuery($tag_bit)
	{
		$tag_bit = (int) $tag_bit;
		if ($tag_bit === 0) {
			return '1';
		}
		$sitecats = GWF_TABLE_PREFIX.'wc_sitecat';
		return "site_tagbits&$tag_bit";
	}
}

?>