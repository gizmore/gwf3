<?php
/**
 * A table of all site masters.
 * @author gizmore
 */
final class WeChall_SiteMasters extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^site_masters$ index.php?mo=WeChall&me=SiteMasters'.PHP_EOL.
			'RewriteRule ^site_masters/by/page-(\d+)$ index.php?mo=WeChall&me=SiteMasters&page=$1'.PHP_EOL.
			'RewriteRule ^site_masters/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=SiteMasters&by=$1&dir=$2&page=$3'.PHP_EOL.
			'RewriteRule ^old_site_masters$ index.php?mo=WeChall&me=SiteMasters&old=1'.PHP_EOL.
			'RewriteRule ^old_site_masters/by/page-(\d+)$ index.php?mo=WeChall&me=SiteMasters&page=$1&old=1'.PHP_EOL.
			'RewriteRule ^old_site_masters/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=SiteMasters&by=$1&dir=$2&page=$3&old=1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		require_once 'module/WeChall/WC_SiteDescr.php';
		return $this->masterTable($module, Common::getGet('old')==='1');
	}
	
	public function masterTable(Module_WeChall $module, $old)
	{
		$masters = GDO::table('WC_SiteMaster');
		$conditions = $old===true ? 'sitemas_options&1=0' : 'sitemas_options&1=1';
		$pre = $old===true?'old_':'';
		$nItems = $masters->countRows($conditions);
		$ipp = $module->cfgItemsPerPage();
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = (int) Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$by = Common::getGet('by', 'sitemas_date');
		$dir = Common::getGet('dir', 'DESC');
		$orderby = $masters->getMultiOrderby($by, $dir);
		$tVars = array(
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.$pre.'site_masters/by/'.urlencode($by).'/'.urlencode($dir).'/page-%PAGE%'),
			'masters' => $masters->selectObjects('*', $conditions, $orderby, $ipp, $from),
			'sort_url' => GWF_WEB_ROOT.$pre.'site_masters/by/%BY%/%DIR%/page-1',
			'old' => $old,
		);
		return $module->templatePHP('site_masters.php', $tVars);
	}
}

?>