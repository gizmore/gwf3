<?php

final class News_Feed extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^news/feed$ index.php?mo=News&me=Feed'.PHP_EOL.
			'RewriteRule ^news/feed/([a-zA-Z]{2})$ index.php?mo=News&me=Feed&iso=$1'.PHP_EOL;
	}
	
	public function execute()
	{
//		$iso = Common::getGet('iso', 'en');
//		if (false === ($lang = GWF_Language::getByISO($iso))) {
//			$lang = GWF_Language::getEnglish();
//		}
		GWF3::setConfig('store_last_url', false);

		$lang = GWF_Language::getCurrentLanguage();
		return $this->templateFeed($lang);
	}
	
	private function templateFeed(GWF_Language $lang)
	{
		header("Content-Type: application/xml; charset=UTF-8");
		
		
		$items = $this->getItems($lang);
		
		if (count($items) > 0)
		{
			$rss_date = $items[key($items)]['pub_date'];
		}
		else
		{
			$rss_date = GWF_Time::rssDate(GWF_Website::getBirthdate());
		}
		
		$tVars = array(
			'items' => $items,
			'title_link' => Common::getAbsoluteURL('news/feed'),
			'language' => $lang->displayName(),
			'image_url' => Common::getAbsoluteURL('favicon.ico'),
			'image_link' => Common::getAbsoluteURL('news'),
			'image_width' => '32',
			'image_height' => '32',
			'pub_date' => $rss_date,
			'build_date' => $rss_date,
		);

		echo
			'<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL.
			$this->_module->templatePHP('feed.php', $tVars);
		
		die();
	}

	private function getItems(GWF_Language $lang)
	{
		$back = array();
		$items = GWF_News::getNews($this->_module->cfgFeedItemcount(), 0, 1, "news_date DESC", false);
		$langid = $lang->getID();
		foreach ($items as $item)
		{
			$item instanceof GWF_News;
			
			$t = $item->getTranslationB($langid);
			$back[] = array(
				'title' => $t['newst_title'],
				'descr' => GWF_Message::display($t['newst_message'], true, false, false),
				'guid' => Common::getAbsoluteURL($item->hrefShow($lang), false),
				'link' => Common::getAbsoluteURL($item->hrefShow($lang), false),
				'date' => $item->displayDate(),
				'pub_date' => $item->rssDate(),
			);
		}
		
		return $back;	
	}
}
?>