<?php

final class News_Preview extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess()
	{
		return 
			'RewriteRule ^newsletter/preview/text$ index.php?mo=News&me=Preview&mode=text'.PHP_EOL.
			'RewriteRule ^newsletter/preview/html$ index.php?mo=News&me=Preview&mode=html'.PHP_EOL;
	}

	/**
	 * @var GWF_News
	 */
	private $news;
	
	public function execute()
	{
		if (false === ($this->news = Module_News::getSavedPreview())) {
			return $this->module->error('err_no_preview');
		}
		
		if (false === ($mail = $this->getPreviewMail())) {
			return $this->module->error('err_no_preview');
		}
		
		switch (Common::getGet('mode'))
		{
			case 'html':
				return $this->previewHTML($mail);
			case 'text':
			default:
				return $this->previewText($mail);
		}
	}
	
	/**
	 * 
	 * @return GWF_Mail
	 */
	private function getPreviewMail()
	{
		$news = $this->news;
		$mail = new GWF_Mail();
		
		$mail->setSubject($news->getTitle());
		$mail->setBody($news->getNewsletterMessage($this->module, 'test@noreply.com'));
		
		return $mail;
	}
	
	private function previewText(GWF_Mail $mail)
	{
		GWF_Website::plaintext();
		die($mail->nestedTextBody());
	}
	
	private function previewHTML(GWF_Mail $mail)
	{
		die($mail->nestedHTMLBody());
	}
}
?>
