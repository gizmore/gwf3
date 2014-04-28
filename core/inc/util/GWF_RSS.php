<?php
final class GWF_RSS
{
	private $title;
	private $descr;
	private $items;
	private $webURL;
	private $feedURL;
		
	public static function displayDate($date)
	{
		return GWF_Time::rssDate($date);
	}
	
	public static function displayCData($data)
	{
		return '<![CDATA['.htmlspecialchars($data).']]>';
	}
	
	public function __construct($title=null, $descr=null, array $items=null, $webURL=null, $feedURL=null)
	{
		$this->title = $title;
		$this->descr = $descr;
		$this->items = $items;
		$this->webURL = $webURL;
		$this->feedURL = $feedURL;
	}
	
	public function setWebURL($webURL)
	{
		$this->webURL = $webURL;
	}
	
	public function setFeedURL($feedURL)
	{
		$this->feedURL = $feedURL;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setDescription($descr)
	{
		$this->descr = $descr;
	}
	
	public function setItems(array $items)
	{
		$this->items = $items;
	}
	
	public function guessRSSDate()
	{
		if (count($this->items) === 0)
		{
			$date = GWF_Website::getBirthdate();
		}
		else
		{
			$item = $this->items[0];
			return $item->getRSSPubDate();
		}
	}
	
	public function export()
	{
		header("Content-Type: application/xml; charset=UTF-8");
		
		$rss_date = self::displayDate($this->guessRSSDate());
		
		$tVars = array(
			'items' => $this->items,
			'title_link' => $this->feedURL,
			'feed_title' => $this->title,
			'feed_description' => $this->descr,
			'language' => GWF_Language::getCurrentISO(),
			'image_url' => Common::getAbsoluteURL('/favicon.ico', false),
			'image_link' => $this->webURL,
			'image_width' => '32',
			'image_height' => '32',
			'pub_date' => $rss_date,
			'build_date' => $rss_date,
		);
		
		return GWF_Template::templatePHPMain('rss2.php', $tVars);
	}
	
}
