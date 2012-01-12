<?php

final class News_Show extends GWF_Method
{
	private $cat = false;
	private $catid = 0;
	private $catTitle = '';
	private $page = 1;
	private $nPages = 1;
	private $numNews = 0;
	
	public function getHTAccess(GWF_Module $module)
	{
//		http://giz.org/news/1/news_1/1/BREAKING%20NEWS%20%C3%9C%C3%9C%22%27
		return 
			# Show news by ID
			# http://giz.org/news/de/5/News_Presse/2/In_THe_PRESS#newsid_2
			'RewriteRule ^news/[a-z]{2}/([0-9]+)/[^/]+/([0-9]+)/[^/]+$ index.php?mo=News&me=Show&catid=$1&newsid=$2'.PHP_EOL.
			'RewriteRule ^news/[a-z]{2}/([0-9]+)/[^/]+$ index.php?mo=News&me=Show&catid=0&newsid=$1'.PHP_EOL.
			# Show all news
			'RewriteRule ^news$ index.php?mo=News&me=Show&catid=0&page=1'.PHP_EOL.
			'RewriteRule ^news/[a-z]{2}$ index.php?mo=News&me=Show&catid=0&page=1'.PHP_EOL.
			# Show by cat and page
			'RewriteRule ^news/[a-z]{2}/([0-9]+)/[^/]+/page-([0-9]+)/?$ index.php?mo=News&me=Show&catid=$1&page=$2'.PHP_EOL.
		
		
			# Comments
//			'RewriteRule ^news/comment/(\\d+) index.php?mo='.PHP_EOL.
			'';
	}
	
	public function execute(GWF_Module $module)
	{
		// Pre Sanatizer / Convert
		if (false !== ($newsid = Common::getGet('newsid'))) {
			if (true !== ($error = $this->convertNewsID($this->_module, $newsid))) {
				return $error;
			}
		}

		$this->sanitize($this->_module);
		
		return $this->templateShow($this->_module);
	}
	
	private function sanitize()
	{
		if (false === ($this->cat = GWF_Category::getByID(Common::getGet('catid', 0)))) {
			$this->catid = 0;
			$this->catTitle = GWF_HTML::lang('no_category');
		} else {
			$this->catid = $this->cat->getID();
			$this->catTitle = $this->cat->getTranslatedText();
		}
		
		$news = GDO::table('GWF_News');
		
		$catQuery = $this->catid === 0 ? '1' : "news_catid=$this->catid";
		$hiddenQuery = "news_options&1=0";
		$condition = "($catQuery) AND ($hiddenQuery)";
		$this->numNews = $news->countRows($condition);
		$npp = $this->_module->getNewsPerPage();
		
		$this->nPages = GWF_PageMenu::getPagecount($npp, $this->numNews);
		$this->page = intval(Common::clamp(Common::getGet('page', '1'), 1, $this->nPages));
	}
	
	private function convertNewsID(Module_News $module, $newsid)
	{
		$news = GDO::table('GWF_News');
		if (false === ($item = $news->getRow($newsid))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === ($catid = Common::getGet('catid')) || $catid !== '0') {
			$catid = $item->getCategoryID();
		} else {
			$catid = 0;
		}
		
		$_GET['catid'] = $catid;
		
		$condition = $catid === 0 ? '' : "news_catid=$catid";
		if (1 > ($page = GWF_PageMenu::getPageFor($item, $condition, 'news_date DESC', $this->_module->getNewsPerPage()))) {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		$_GET['page'] = $page;
		
		return true;
	}
	
	public function templateShow()
	{
		if (false === ($news = GWF_News::getNewsQuick($this->_module->getNewsPerPage(), $this->catid, $this->page, GWF_Language::getCurrentID()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}		
		
		$date = count($news) > 0 ? $news[0]['news_date'] : GWF_Settings::getSetting('gwf_site_birthday').'090000';
		$date = GWF_Time::displayDate($date);
		GWF_Website::setPageTitle($this->_module->lang('pt_news', array( $date)));
		GWF_Website::setMetaTags($this->_module->lang('mt_news', array( $date)));
		GWF_Website::setMetaDescr($this->_module->lang('md_news', array( $this->page, $this->nPages)));
		
//		$mod_forum = GWF_Module::getModule('Forum', true);
		
		$tVars = array(
			'news' => $news,
			'titles' => GWF_News::getTitlesQuick($this->catid, GWF_Language::getCurrentID()),
			'cats' => GWF_News::getCategories(),
			'catid' => $this->catid,
			'cat' => GWF_HTML::display($this->catTitle),
			'page_menu' => $this->getPageMenu(),
			'page' => $this->page,
			'can_sign' => $this->_module->canSignNewsletter(GWF_Session::getUser()),
			'href_sign_news' => $this->_module->hrefSignNewsletter(),
//			'href_unsign' => GWF_WEB_ROOT.'newsletter/subscribe',
			'may_add' => GWF_User::isAdminS() || GWF_User::isStaffS(),
			'href_add' => $this->_module->hrefAddNews(),
//			'with_forum' => ( ($mod_forum !== false) && ($this->_module->cfgNewsInForum()) ),
//			'href_comments_more' => GWF_WEB_RO
		
		);
		return $this->_module->templatePHP('show.php', $tVars);
	}
	
	private function getPageMenu()
	{
		$iso = GWF_Language::getCurrentISO();
		$href = sprintf(GWF_WEB_ROOT.'news/%s/%d/%s/page-%%PAGE%%', $iso, $this->catid, urlencode($this->catTitle));
		return GWF_PageMenu::display($this->page, $this->nPages, $href);
	}
}

?>