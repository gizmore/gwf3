<?php
final class News_Admin extends GWF_Method
{
	private $page;
	private $nPages;
	private $nItems;
	private $ipp;
	private $by;
	private $dir;
	
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess()
	{
		return 
			'RewriteRule ^news/admin$ index.php?mo=News&me=Admin&page=1&by=date&dir=DESC'.PHP_EOL.
			'RewriteRule ^news/admin/page/([0-9]+)/by/([a-zA-Z_,]+)/([DEASC,]+)$ index.php?mo=News&me=Admin&page=$1&by=$2&dir=$3'.PHP_EOL;
	}
	
	public function execute()
	{
		$this->sanitize();
		
		return $this->templateOverview();
	}
	
	private function sanitize()
	{
		$news = GDO::table('GWF_News');
		$this->nItems = $news->countRows();
		$this->ipp = $this->_module->getNewsPerAdminPage();
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp(Common::getGet('page', 1), 1, $this->nPages);;
		$this->by = $news->getWhitelistedBy(Common::getGet('by', 'news_date'), 'news_date', false);
		$this->dir = GDO::getWhitelistedDirS(Common::getGet('dir', 'DESC'), 'DESC');
		$this->orderby = $news->getMultiOrderby($this->by, $this->dir);
	}
	
	private function templateOverview()
	{
		$tVars = array(
			'news' => GWF_News::getNews($this->_module->getNewsPerAdminPage(), 0, $this->page, $this->orderby, true),
			'orderby' => $this->by,
			'orderdir' => $this->dir,
			'orderurl' => GWF_WEB_ROOT.'news/admin/page/1/by/%BY%/%DIR%',
			'page_menu' => $this->getPageMenu(),
		);
		return $this->_module->templatePHP('admin.php', $tVars);
	}
	
	private function getPageMenu()
	{
		$href = sprintf(GWF_WEB_ROOT.'news/admin/page/%%PAGE%%/by/%s/%s', $this->by, $this->dir);
		return GWF_PageMenu::display($this->page, $this->nPages, $href);
	}
}
?>