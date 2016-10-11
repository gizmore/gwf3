<?php
final class Wanda_ReadPage extends GWF_Method
{
	private $book;
	private $page;
	
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/book/([0-9]+)/page/([0-9]+)/?$ index.php?mo=Wanda&me=ReadPage&book=$1&page=$2'.PHP_EOL;
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
		);
		return $this->module->templatePHP('page.php', $tVars);
	}
	
	private function renderContent($book, $page)
	{
		$iso = GWF_Language::getCurrentISO();
		$file = sprintf('%s/module/Wanda/content/book%d/%s/page%d.php', GWF_CORE_PATH, $book, $iso, $page);
		return $this->module->coreTemplatePHP($file);
	}
	
}