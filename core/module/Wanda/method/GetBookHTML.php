<?php
final class Wanda_GetBookHTML extends GWF_Method
{
	private $book;
	private $pdfFilename;
	
	public function execute()
	{
		if (false !== ($error = $this->validate()))
		{
			return $error;
		}
		
		$this->pdfFilename = $this->generatePDFFilename($this->book);
		
		return ($this->generateHTML($this->book, $this->pdfFilename));
	}
	
	public function generatePDFFilename($book)
	{
		return sprintf("[Wanda]_{$book}_%s", $this->module->getBookTitle($book));
	}
	
	private function validate() {
		if (!($this->book = $this->module->validateBookId(Common::getGetInt('book'))))
		{
			return $this->module->error('err_no_book');
		}
		return false;
	}
	
	public function generateHTML($book, $pdfFilename)
	{
		$nPages = $this->module->getWandaPagecount($book);
		$tVars = array(
				'text' => $this->generatePageContents($book, $nPages),
				'prev' => null,
				'next' => null,
				'book' => $book,
				'page' => null,
				'booktitle' => $pdfFilename,
		);
		return $this->module->templatePHP('page.php', $tVars);
	}
	
	public function generatePageContents($book, $nPages)
	{
		$content = '';
		for ($page = 1; $page <= $nPages; $page++)
		{
			$content.= '<div class="pdf-page">';
			$content.= $this->renderContent($book, $page);
			$content.= '</div>';
		}
		return $content;
	}

	private function renderContent($book, $page)
	{
		$iso = GWF_Language::getCurrentISO();
		$file = sprintf('%s/module/Wanda/content/book%d/%s/page%d.php', GWF_CORE_PATH, $book, $iso, $page);
		return $this->module->coreTemplatePHP($file);
	}
}
