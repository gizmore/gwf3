<?php
/**
 * A news item.
 * @author gizmore
 */
final class Dog_News extends GDO
{
	const DISPLAYED = 0x01;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_news'; }
	public function getOptionsName() { return 'ln_options'; }
	public function getColumnDefines()
	{
		return array(
			'ln_id' => array(GDO::AUTO_INCREMENT),
			'ln_fid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'ln_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'ln_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'ln_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ln_descr' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ln_options' => array(GDO::UINT, 0),
		);
	}
	
	public function isDisplayed() { return $this->isOptionEnabled(self::DISPLAYED); }
	
	public static function getByTitle($feed_id, $title)
	{
		$feed_id = (int) $feed_id;
		$title = self::escape($title);
		return self::table(__CLASS__)->selectFirstObject('*', "ln_fid=$feed_id AND ln_title='$title'");
	}
	
	public static function getByURL($feed_id, $url)
	{
		$feed_id = (int) $feed_id;
		$url = self::escape($url);
		return self::table(__CLASS__)->selectFirstObject('*', "ln_fid=$feed_id AND ln_url='$url'");
		
	}
	
}
?>