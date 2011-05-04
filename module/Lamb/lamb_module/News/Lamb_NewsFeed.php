<?php
/**
 * IRC Bot RSS News Feed entry
 * @author gizmore
 */
final class Lamb_NewsFeed extends GDO
{
	# General
	const DELETED = 0x01;
	const AUTO_FEED = 0x02;
	# Versions
	const RSS_09 = 0x10;
	const RSS_20 = 0x20;
	const RSS_VERSIONS = 0x30;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lambnewsfeed'; }
	public function getOptionsName() { return 'lnf_options'; }
	public function getColumnDefines()
	{
		return array(
			'lnf_id' => array(GDO::AUTO_INCREMENT),
			'lnf_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'lnf_url' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 255),
			'lnf_options' => array(GDO::UINT, 0),
			'lnf_lastdate' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function isDeleted()
	{
		return $this->isOptionEnabled(self::DELETED);
	}
	
	public function saveRSSVersion($version_bit)
	{
		if (false === $this->saveOption(self::RSS_VERSIONS, false)) {
			return false;
		}
		return $this->saveOption($version_bit, true);
	}
	
	##############
	### Static ###
	##############
	/**
	 * @param int $id
	 * @return Lamb_NewsFeed
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * @param $url
	 * @return Lamb_NewsFeed
	 */
	public static function getByURL($url)
	{
		$url = self::escape($url);
		return self::table(__CLASS__)->selectFirstObject('*', "lnf_url='$url'");
	}
	
	public static function getWorkingFeeds()
	{
		return self::table(__CLASS__)->selectObjects('*', "lnf_options&0x01=0");
	}
	
	##############
	### Delete ###
	##############
	public function onDelete()
	{
		return $this->saveOption(self::DELETED, true);
	}
	
	public function onUnDelete()
	{
		return $this->saveOption(self::DELETED, false);
	}
}
?>