<?php
final class News_Delete extends GWF_Method
{
	private $newsID;
	
	public function deleteNews($news)
	{
		if (!$news->delete())
		{
			return GWF_HTML::err()
		}
		return true;
	}
	
	public function deleteNewsByID($newsid)
	{
		if (false === ($news = GWF_News::getNewsItem($newsid)))
		{
			return $this->module->error('err_news');
		}
		
		return $this->deleteNews($news);
	}
		
	
	private function validate()
	{
		if (false === ($this->newsID = Common::getPostString('newsid')))
		{
			return $this->module->error('err_newsid');
		}
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
		
		if (true !== ($result = $this->deleteNewsByID($this->newsID))) {
			return GWF_HTML::err()
		}
		
		if (!isset($_GET['ajax'])) {
			GWF_Website::redirect('/news');
		}
	}
	
	public function executeAjax()
	{
	}
}
