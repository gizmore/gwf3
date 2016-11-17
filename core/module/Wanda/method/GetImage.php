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
		if (false !== ($error = $this->validate()))
		{
			return $error;
		}
		$filename = sprintf('%smodule/Wanda/content/images_medium/images/Book%dPage%02dImage%d.png', GWF_CORE_PATH, $this->book, $this->page, $this->image);
		if (file_exists($filename)) {
			header("Content-Type: image/png");
			die(file_get_contents($filename));
		}
		else {
			die('No such image Hertz!');
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
/*


public function sendTheFile(GWF_Download $dl)
{
	GWF3::setConfig('store_last_url', false);

	$realpath = $dl->getCustomDownloadPath();
	# http header
	$mime = $dl->getVar('dl_mime'); # currently i am looking for pecl filetype?
	$mime = 'application/octet-stream'; # not sure about...
	//		$name = $dl->getVar('dl_filename'); # filename is sane. No " is allowed in filename.
	$name = $dl->getCustomDownloadName();
	header("Content-Disposition: attachment; filename=\"$name\""); # drop attachment?
	$size = filesize($realpath);
	header("Content-Length: $size");
	# Print file and die
	echo file_get_contents($realpath);
	die(0);
}
*/