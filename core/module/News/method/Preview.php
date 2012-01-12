<?php

final class News_Preview extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^newsletter/preview/text$ index.php?mo=News&me=Preview&mode=text'.PHP_EOL.
			'RewriteRule ^newsletter/preview/html$ index.php?mo=News&me=Preview&mode=html'.PHP_EOL;
	}

	/**
	 * @var GWF_News
	 */
	private $news;
	
	public function execute(GWF_Module $module)
	{
		if (false === ($this->news = Module_News::getSavedPreview())) {
			return $this->_module->error('err_no_preview');
		}
		
		if (false === ($mail = $this->getPreviewMail($this->_module))) {
			return $this->_module->error('err_no_preview');
		}
		
		switch (Common::getGet('mode'))
		{
			case 'html':
				return $this->previewHTML($this->_module, $mail);
			case 'text':
			default:
				return $this->previewText($this->_module, $mail);
		}
	}
	
	/**
	 * 
	 * @param Module_News $module
	 * @return GWF_Mail
	 */
	private function getPreviewMail(Module_News $module)
	{
		$news = $this->news;
		$mail = new GWF_Mail();
		
		$mail->setSubject($news->getTitle());
		$mail->setBody($news->getNewsletterMessage($this->_module, 'test@noreply.com'));
		
		return $mail;
	}
	
	private function previewText(Module_News $module, GWF_Mail $mail)
	{
		header('Content-Type: text/plain');
		die($mail->nestedTextBody());
	}
	
	private function previewHTML(Module_News $module, GWF_Mail $mail)
	{
		die($mail->nestedHTMLBody());
	}
	
}


?>