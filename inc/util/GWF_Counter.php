<?php
/**
 * Simple counter, key => intvalue.
 * @author gizmore
 */
final class GWF_Counter extends GDO
{
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'counter'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'count_key' => array(GDO::PRIMARY_KEY|GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 64),
			'count_value' => array(GDO::UINT, 0),
		);
	}
	###################
	### Convinience ###
	###################
	/**
	 * Get a counter and count up by one.
	 * @param string $key
	 * @return string the value
	 */
	public static function getAndCount($key, $by=1)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($key))) {
			$row = new self(array('count_key'=>$key,'count_value'=>$by));
			$row->insert();
		} else {
			$row->increase('count_value', $by);
		}
		return $row->getVar('count_value');
	}
	
	/**
	 * Get a counter value.
	 * @param string $key
	 * @return int
	 */
	public static function getCount($key)
	{
		$key = self::escape($key);
		if (false === ($value = self::table(__CLASS__)->selectVar('count_value', "count_key='$key'"))) {
			return 0;
		}
		return (int)$value;
	}
	
	/**
	 * Increase or decrease a counter.
	 * @param string $key
	 * @param int $by
	 * @return boolean
	 */
	public static function increaseCount($key, $by=1)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($key))) {
			$row = new self(array('count_key'=>$key,'count_value'=>$by));
			return $row->insert();
		} else {
			return $row->increase('count_value', $by);
		}
	}
	
	/**
	 * Set a counter to a fixed value.
	 * @param string $key
	 * @param int $value
	 * @return boolean
	 */
	public static function saveCounter($key, $value)
	{
		$row = new self(array('count_key'=>$key,'count_value'=>$value));
		return $row->replace();
	}
}
?>