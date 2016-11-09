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
		die($content);
		
		// create handle for new PDF document
		$pdf = pdf_new();
		// open a file
		pdf_open_file($pdf, "test.pdf");
		// start a new page (A4)
		pdf_begin_page($pdf, 595, 842);
		// get and use a font object
		$arial = pdf_findfont($pdf, "Arial", "host", 1); pdf_setfont($pdf, $arial, 10);
		// print text
		pdf_show_xy($pdf, "There are more things in heaven and earth, Horatio,",50, 750);
		pdf_show_xy($pdf, "than are dreamt of in your philosophy", 50,730);
		// end page
		pdf_end_page($pdf);
		// close and save file
		pdf_close($pdf);
		
		
		
		
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


