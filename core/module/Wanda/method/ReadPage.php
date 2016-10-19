<?php
final class Wanda_ReadPage extends GWF_Method
{
	private $book;
	private $page;
	
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/book/([0-9]+)/page/([0-9]+)/?$ index.php?mo=Wanda&me=ReadPage&book=$1&page=$2'.PHP_EOL;
	}
	
	public function getPageURL($book, $page)
	{
		return sprintf(GWF_WEB_ROOT.'wanda/book/%s/page/%s', $book, $page);
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate()))
		{
			return $error;
		}
		
		$this->countClick($this->book, $this->page);
		
		return $this->renderBookPage($this->book, $this->page);
	}
	
	private function validate()
	{
		if (false === ($this->book = Common::getGetInt('book'))) {
			return $this->module->error('err_no_book');
		}
		if (false === ($this->page = Common::getGetInt('page'))) {
			return $this->module->error('err_no_page');
		}
		return false;
	}
	
	private function countClick()
	{
		GWF_CachedCounter::getAndCount($this->getClickCounterPath());
	}
	
	private function getClickCounterPath() {
		return sprintf('WB%sP%s', $this->book, $this->page);
	}
	
	############
	### Read ###
	############
	private function renderBookPage($book, $page)
	{
		$tVars = array(
			'text' => $this->renderContent($book, $page),
			'prev' => $this->getPrevHREF($book, $page),
			'next' => $this->getNextHREF($book, $page),
			'book' => $book,
			'page' => $page,
			'booktitle' => $this->module->getBookTitle($book),
		);
		return $this->module->templatePHP('page.php', $tVars);
	}
	
	private function renderContent($book, $page)
	{
		$iso = GWF_Language::getCurrentISO();
		$file = $this->getBestFileForISO($iso);
		return $this->module->coreTemplatePHP($file);
	}
	
	private function getBestFileForISO($iso)
	{
		$file = sprintf('%s/module/Wanda/content/book%d/%s/page%d.php', GWF_CORE_PATH, $this->book, $iso, $this->page);
		if (!file_exists($file)) {
			if ($iso != 'en') {
				return $this->getBestFileForISO('en');
			}
		}
		return $file;
	}
	
	private function getPrevHREF($book, $page)
	{
		if (($book == 1) && ($page == 1))
		{
			return null;
		}
		else if ($page == 1)
		{
			$book -= 1; // One book down
			$page = $this->module->getWandaPagecount($book); // last page
		}
		else
		{
			$page -= 1;	
		}
		
		return $this->getPageURL($book, $page);
	}
	
	private function getNextHREF($book, $page)
	{
		if ($this->isTotalLastPage($book, $page))
		{
			return null;
		}
		
		$pages = $this->module->getWandaPagecount($book);
		if ($page == $pages)
		{
			$book += 1;
			$page = 1;
		}
		else
		{
			$page += 1;
		}
	
		return $this->getPageURL($book, $page);
	}
	
	private function isTotalLastPage($book, $page)
	{
		return (($book >= 2)&&($page >= 2));
	}
	
}