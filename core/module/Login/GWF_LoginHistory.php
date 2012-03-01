<?php
final class GWF_LoginHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'login_history'; }
	public function getColumnDefines()
	{
		return array(
			'loghis_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'loghis_time' => array(GDO::UINT, GDO::NOT_NULL),
			'loghis_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL),
		);
	}
	
	##############
	### Static ###
	##############
	/**
	 * Insert an event on login.
	 * @param int $userid
	 * @return boolean
	 */
	public static function insertEvent($userid)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'loghis_uid' => $userid,
			'loghis_time' => time(),
			'loghis_ip' => GWF_IP6::getIP(GWF_IP_EXACT),
		), false);
	}
	
	/**
	 * Get the last login.
	 * @param int $userid
	 * @return GWF_LoginHistory
	 */
	public static function getLastLogin($userid)
	{
		$userid = (int)$userid;
		return self::table(__CLASS__)->selectFirst('*', "loghis_uid={$userid}", 'loghis_time DESC', NULL, GDO::ARRAY_O, 1);
	}
	
	###############
	### Display ###
	###############
	public function displayIP() { return GWF_IP6::displayIP($this->getVar('loghis_ip'), GWF_IP_EXACT); }
	public function displayDate() { return GWF_Time::displayTimestamp($this->getVar('loghis_time')); }
	public function displayHostname() { return gethostbyaddr($this->displayIP()); }
}
?>