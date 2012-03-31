<?php
/**
 * Table of IP => User association to identify web spiders.
 * @author gizmore
 */
final class GWF_Webspider extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'web_spiders'; }
	public function getColumnDefines()
	{
		return array(
			'wesp_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'wesp_uid')),
			'wesp_ip_min' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 32),
			'wesp_ip_max' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 32),
		);
	}

	public static function insertSpider($uid, $ipmin, $ipmax)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'wesp_uid' => $uid,
			'wesp_ip_min' => $ipmin,
			'wesp_ip_max' => $ipmax,
		));
	}

	/**
	 * @return GWF_User
	 */
	public static function getSpider()
	{
		return self::getSpiderByIPHex128(GWF_IP6::getIP(GWF_IP6::HEX_128));
	}

	/**
	 * Get a robot by IP
	 * @param string $ip human notation
	 * @return GWF_User
	 */
	public static function getSpiderByIP($ip)
	{
		return self::getSpiderByIPHex128(GWF_IP6::getIP(GWF_IP6::HEX_128, $ip));
	}

	/**
	 * @param string IP hex128
	 * @return GWF_User
	 */
	public static function getSpiderByIPHex128($ip)
	{
		$ip = str_repeat('0', 32-strlen($ip)).$ip;
		return self::table(__CLASS__)->selectVar('wesp_uid', "wesp_ip_min<='$ip' AND wesp_ip_max>='$ip'");
//		if (false === ($row = self::table(__CLASS__)->selectVar('') FirstObject('*', "wesp_ip_min<='$ip' AND wesp_ip_max>='$ip'"))) {
//			return false;
//		}
//		return $row->getVar('wesp_uid');
	}

}
