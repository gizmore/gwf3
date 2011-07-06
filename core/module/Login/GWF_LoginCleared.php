<?php
final class GWF_LoginCleared extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'login_cleared'; }
	public function getColumnDefines()
	{
		return array(
			'lc_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lc_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'lc_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL),
		);
	}
	
	public function displayIP() { return GWF_IP6::displayIP($this->getVar('lc_ip'), GWF_IP_EXACT); }
	public function displayHost() { return gethostbyaddr($this->displayIP()); }
	public function displayDate() { return GWF_Time::displayDate($this->getVar('lc_date')); }
	
	public static function updateCleared($userid)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lc_uid' => $userid,
			'lc_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'lc_ip' => GWF_IP6::getIP(GWF_IP_EXACT),
		), true);
	}
	
	public static function getCleared($userid)
	{
		$userid = (int) $userid;
		return self::table(__CLASS__)->selectFirstObject('*', "lc_uid=$userid");
	}
}
?>