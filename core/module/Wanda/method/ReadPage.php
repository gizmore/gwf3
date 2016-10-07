<?php
final class ReadPage extends GWF_Method
{
	private $book;
	private $page;
	
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/book/([0-9]+)/page/([0-9]+)/?$ index.php?mo=Wanda&me=ReadPage&book=$1&page=$2'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
	}
	
	private function validate() {
		if (false === ($this->book = Common::getGetInt('book'))) {
			return $this->module->error('err_no_book');
		}
		if (false === ($this->page = Common::getGetInt('page'))) {
			return $this->module->error('err_no_page');
		}
		return false;
	}
	
}