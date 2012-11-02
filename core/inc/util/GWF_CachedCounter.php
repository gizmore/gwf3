<?php
/**
 * Simple counter, key => intvalue.
 * @author gizmore
 */
final class GWF_CachedCounter extends GDO
{
	private static $CACHE = array();
	
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'ccounter'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'count_key' => array(GDO::PRIMARY_KEY|GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 63),
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
		self::increaseCount($key, $by);
		return self::getCount($key);
	}

	/**
	 * Get a counter value.
	 * @param string $key
	 * @return int
	 */
	public static function getCount($key)
	{
		if (!isset(self::$CACHE[$key]))
		{
			$ekey = self::escape($key);
			if (false === ($value = self::table(__CLASS__)->selectVar('count_value', "count_key='{$ekey}'")))
			{
				$value = 0;
			}
			self::$CACHE[$key] = $value;
		}
		return self::$CACHE[$key];
	}

	/**
	 * Increase or decrease a counter.
	 * @param string $key
	 * @param int $by
	 * @return boolean
	 */
	public static function increaseCount($key, $by=1)
	{
		if (!isset(self::$CACHE[$key]))
		{
			self::$CACHE[$key] = $by;
		}
		else
		{
			self::$CACHE[$key] += $by;
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
		self::$CACHE[$key] = $by;
	}
	
	public static function persist()
	{
		$table = self::table(__CLASS__);
		foreach (self::$CACHE as $key => $value)
		{
			$table->insertAssoc(array('count_key' => $key, 'count_value' => $value));
		}
	}
}
?>
