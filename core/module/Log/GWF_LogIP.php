<?php
/**
 * Log IP+UA.
 * @author gizmore
 * @version 3.0
 * @since 2.0
 */
final class GWF_LogIP extends GDO
{
	const UA_HASH_LEN = 16;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'log_ip'; }
	public function getColumnDefines()
	{
		return array(
			'iplog_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'iplog_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL, GDO::PRIMARY_KEY),
			'iplog_ua' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NULL, self::UA_HASH_LEN),
			'iplog_time' => array(GDO::TIME),
		);
	}
	
	/**
	 * Hash the useragent roughly.
	 * @return string
	 */
	public static function getUAHash()
	{
		return strtoupper(substr(md5(GWF_IP6::getUserAgent()), 0, self::UA_HASH_LEN));
	}
	
	/**
	 * Log the current UID+IP+UA
	 * Enter description here ...
	 */
	public static function logIP()
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'iplog_uid' => GWF_Session::getUserID(),
			'iplog_ip' => GWF_IP6::getIP(GWF_IP_EXACT),
			'iplog_ua' => self::getUAHash(),
			'iplog_time' => time(),
		), true);
	}
}
?>