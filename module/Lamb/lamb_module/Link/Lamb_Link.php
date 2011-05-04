<?php
final class Lamb_Link extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_links'; }
	public function getColumnDefines()
	{
		return array(
			'link_id' => array(GDO::AUTO_INCREMENT),
			'link_text' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'link_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'link_username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, '', 64),
			'link_rating' => array(GDO::INT, 0),
			'link_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}

	##############
	### Static ###
	##############
	/**
	 * Get a link by ID.
	 * @param int $link_id
	 * @return Lamb_Link
	 */
	public static function getByID($link_id)
	{
		return self::table(__CLASS__)->getRow($link_id);
	}
	
	public static function getRandomID()
	{
		if (false === ($row = self::table(__CLASS__)->selectRandom('link_id', '', '1', NULL, GDO::ARRAY_N))) {
			return false;
		}
		return $row[0];
	}
	
	/**
	 * Get a link by URL.
	 * @param int $link_id
	 * @return Lamb_Link
	 */
	public static function getByURL($link_url)
	{
		$link_url = GDO::escape($link_url);
		return self::table(__CLASS__)->selectFirstObject('*', "link_url='$link_url'");
	}
	
	/**
	 * Insert a new link.
	 * @param string $username
	 * @param string $url
	 * @param string $description
	 * @return Lamb_Link
	 */
	public static function insertLink($username, $url, $description)
	{
		$link = new self(array(
			'link_id' => 0,
			'link_text' => $description,
			'link_url' => $url,
			'link_username' => $username,
			'link_rating' => 0,
			'link_date' => GWF_Time::getDate(14),
		));
		if (false === $link->insert()) {
			return false;
		}
		return $link;
	}
	
	/**
	 * Search the links database and return an array of IDs.
	 * @param $term
	 * @return array
	 */
	public static function searchLinks($term)
	{
		$links = self::table(__CLASS__);
		$conditions = GWF_QuickSearch::getQuickSearchConditions($links, array('link_url', 'link_text'), $term);
		return $links->selectColumn('link_id', $conditions, 'link_id DESC');
	}
	
}
?>