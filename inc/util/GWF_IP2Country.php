<?php
/**
 * Map IPv4 to Country IDs
 * @author gizmore
 * @version 1.0
 */
final class GWF_IP2Country extends GDO
{
	# Cache
	private static $detectedCountry = true;

	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'ip2country'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'ip2c_start' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'ip2c_end' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'ip2c_cid' => array(GDO::UINT| GDO::NOT_NULL),
		);
	}
	
	########################
	### Static Detection ###
	########################
	public static function detectCountry()
	{
		return GWF_Country::getByID(self::detectCountryID());
	}
	
	public static function detectCountryID()
	{
		if (self::$detectedCountry !== true) {
			if (self::$detectedCountry === false) {
				return 0;
			}
			return self::$detectedCountry->getVar('ip2c_cid');
		}
		$ip = GWF_IP6::getIP(GWF_IP6::UINT_32);
		if (false === (self::$detectedCountry = self::table(__CLASS__)->selectVar('ip2c_cid', "ip2c_start<='$ip' AND ip2c_end>='$ip'"))) {
			return false;
		}
		return self::$detectedCountry;
	}
}
?>
