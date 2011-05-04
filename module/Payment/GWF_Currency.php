<?php
/**
 * @author gizmore
 */
final class GWF_Currency extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'currency'; }
	public function getColumnDefines()
	{
		return array(
			'curr_iso' => array(GDO::PRIMARY_KEY|GDO::TOKEN, GDO::NOT_NULL, 3),
			'curr_cid' => array(GDO::PRIMARY_KEY|GDO::UINT, GDO::NOT_NULL),
			'curr_char' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 4),
			'curr_digits' => array(GDO::TINYINT, 2),
		);
	}
	
	public static function getISOs()
	{
		return self::table(__CLASS__)->selectColumn('curr_iso');
	}
	
	/**
	 * @param string $iso
	 * @return GWF_Currency
	 */
	public static function getByISO($iso)
	{
		return self::table(__CLASS__)->selectFirstObject('*', 'curr_iso=\''.self::escape($iso).'\'');
	}
	
	public function getSymbol()
	{
		return $this->getVar('curr_char');
	}
	
	public function displayValue($value, $with_symbol=true)
	{
		return sprintf('%s%.0'.$this->getVar('curr_digits').'f', $with_symbol ? $this->getSymbol().'' : '', $value);
	}
}

?>
