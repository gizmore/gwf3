<?php
require_once GWF_PATH.'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

final class Wanda_GeneratePDF extends GWF_Method
{
	private $bookNumber;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/pdf/book/([0-9]+)/?$ index.php?mo=Wanda&me=GeneratePDF&book=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}

		$BookHTML = $this->module->getMethod('GetBookHTML');
		$title = $this->module->getBookTitle($this->bookNumber);
		$pages = $BookHTML->generatePageContents($this->bookNumber, $this->module->getWandaPagecount($this->bookNumber));
		$content = $this->module->templatePHP('pdf.php', array('title' => $title, 'pages' => $pages));
// 		die($content);

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
// 		$dompdf->set_option('defaultFont', 'Courier');
		
		$dompdf->loadHtml($content);
		
		// (Optional) Setup the paper size and orientation
// 		$dompdf->setPaper('A4', 'landscape');
		
		// Render the HTML as PDF
		$dompdf->render();
		
		// Output the generated PDF to Browser
		$dompdf->stream();
		
		
	}

	###############
	### private ###
	###############
	private function validate()
	{
		if (false === ($this->bookNumber = $this->module->validateBookId(Common::getGetString('book')))) {
			return $this->module->error('err_book');
		}
		return false;
	}

}


