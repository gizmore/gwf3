<?php
final class Wanda_GetImage extends GWF_Method
{
	private $book;
	private $page;
	private $image;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/image/book/([0-9]+)/page/([0-9]+)/image/([0-9]+)/?$ index.php?mo=Wanda&me=GetImage&book=$1&page=$2&image=$3'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
	}
	
	private function validate() {
		if (false === ($this->book = Common::getGetInt('book')))
		{
			return $this->module->error('err_no_book');
		}
		if (false === ($this->page = Common::getGetInt('page')))
		{
			return $this->module->error('err_no_page');
		}
		if (false === ($this->image = Common::getGetInt('image')))
		{
			return $this->module->error('err_no_image');
		}
		return false;
	}
	
}