<?php
final class News_Toggle extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function execute()
	{
		if (false === ($news = GWF_News::getByID(Common::getGetString('newsid', '0'))))
		{
			return $this->module->error('err_news');
		}
		
#		$oldhidden = $news->isHidden();
		$newhidden = Common::getGetString('hidden') === '1';
		
		if (false === $news->saveOption(GWF_News::HIDDEN, $newhidden))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_hidden_'.($newhidden?1:0));
	}
}
?>
