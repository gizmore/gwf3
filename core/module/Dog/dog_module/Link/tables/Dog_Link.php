<?php
final class Dog_Link extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_links'; }
	public function getColumnDefines()
	{
		return array(
			'link_id' => array(GDO::AUTO_INCREMENT),
			'link_uid' => array(GDO::OBJECT, 0, array('DOG_User', 'user_id', 'link_uid')),
			'link_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'link_text' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'link_rating' => array(GDO::INT, 0),
			'link_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}
	
	public function getID() { return $this->getVar('link_id'); }
	public function getURL() { return $this->getVar('link_url'); }
	public function getText() { return $this->getVar('link_text'); }
	public function getRating() { return $this->getVar('link_rating'); }
	public function displayText() { return Common::stripMessage($this->getText(), 320); }
		
	##############
	### Static ###
	##############
	/**
	 * Get a link by ID.
	 * @param int $link_id
	 * @return Dog_Link
	 */
	public static function getByID($link_id)
	{
		return self::table(__CLASS__)->getRow($link_id);
	}
	
	public static function getRandomID()
	{
		if (false === ($row = self::table(__CLASS__)->selectRandom('link_id', '', '1', NULL, GDO::ARRAY_N)))
		{
			return false;
		}
		return $row[0];
	}
	
	/**
	 * Get a link by URL.
	 * @param int $link_id
	 * @return Dog_Link
	 */
	public static function getByURL($link_url)
	{
		$link_url = GDO::escape($link_url);
		return self::table(__CLASS__)->selectFirstObject('*', "link_url='$link_url'");
	}
	
	/**
	 * Insert a new link.
	 * @param int $uid
	 * @param string $url
	 * @param string $description
	 * @return Dog_Link
	 */
	public static function insertLink($uid, $url, $description)
	{
		$link = new self(array(
			'link_id' => '0',
			'link_uid' => $uid,
			'link_url' => $url,
			'link_text' => $description,
			'link_rating' => '0',
			'link_date' => GWF_Time::getDate(14),
		));
		return false === $link->insert() ? false : $link;
	}
	
	/**
	 * Search the links database and return an array of IDs.
	 * @param $term
	 * @return array
	 */
	public static function searchLinks($term)
	{
		$links = self::table(__CLASS__);
		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($links, array('link_url', 'link_text'), $term)))
		{
			return array();
		}
		return $links->selectColumn('link_id', $conditions, 'link_id DESC');
	}
}
?>
