<?php
final class Lamb_Quote extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_quotes'; }
	public function getColumnDefines()
	{
		return array(
			'quot_id' => array(GDO::AUTO_INCREMENT),
			'quot_text' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'quot_username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, '', 64),
			'quot_rating' => array(GDO::INT, 0),
			'quot_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}
	
	public function displayDate()
	{
		return GWF_Time::displayDate($this->getVar('quot_date'));
	}
	
	/**
	 * @param unknown_type $quot_id
	 * @return Lamb_Quote
	 */
	public static function getByID($quot_id)
	{
		return self::table(__CLASS__)->getRow($quot_id);
	}
	
	public static function getRandomID()
	{
		return self::table(__CLASS__)->selectVar('quot_id', '', 'rand()');
	}
	
	/**
	 * Search the quotes. Return array of matching IDs.
	 * @param string $term
	 * @return array
	 */
	public static function searchQuotes($term)
	{
		$quotes = self::table(__CLASS__);
		$conditions = GWF_QuickSearch::getQuickSearchConditions($quotes, array('quot_text'), $term);
		return $quotes->selectColumn('quot_id', $conditions, 'quot_id');
	}
	
	/**
	 * Insert a new quote.
	 * @param string $username
	 * @param string $text
	 * @return Lamb_Quote
	 */
	public static function insertQuote($username, $text)
	{
		$quote = new self(array(
			'quot_id' => 0,
			'quot_text' => $text,
			'quot_username' => $username,
			'quot_rating' => 0,
			'quot_date' => GWF_Time::getDate(14),
		));
		if (false === $quote->insert()) {
			return false;
		}
		return $quote;
	}
}
?>