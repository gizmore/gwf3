<?php
/**
 * Simple key=>value table for settings.
 * @see GWF_Counter
 * @since 1.0
 * @author gizmore
 * @version 3.0
 */
final class GWF_Settings extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'settings'; }
	public function __toString() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'set_key' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 64),
			'set_val' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		);
	}

	private static function getSettingB($var, $default='')
	{
		$var = GDO::escape($var);
		if (false === ($val = self::table(__CLASS__)->selectVar('set_val', "set_key='$var'")))
		{
			return $default;
		}
		return $val;
	}

	private static function setSettingB($var, $value)
	{
		self::$CACHE[$var] = $value;
		return self::table(__CLASS__)->insertAssoc(array('set_key' => $var, 'set_val' => $value), true);
	}

	public static function unsetSetting($var)
	{
		unset(self::$CACHE[$var]);
		$var = GDO::escape($var);
		return self::table(__CLASS__)->deleteWhere("set_key='$var'");
	}
	
	######################
	### Cached version ###
	######################
	private static $CACHE = array();
	public static function getSetting($var, $default='')
	{
		return isset(self::$CACHE[$var]) ? self::$CACHE[$var] : self::getFillCache($var, $default);
	}
	private static function getFillCache($var, $default)
	{
		self::$CACHE[$var] = self::getSettingB($var, $default);
		return self::$CACHE[$var];
	}
	public static function setSetting($var, $value)
	{
		return self::setSettingB($var, $value);
	}
}
