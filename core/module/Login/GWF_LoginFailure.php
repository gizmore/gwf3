<?php
final class GWF_LoginFailure extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'loginfail'; }
	public function getColumnDefines()
	{
		return array(
			'logfail_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL, GDO::INDEX),
			'logfail_uid' => array(GDO::UINT|GDO::INDEX, true),
			'logfail_time' => array(GDO::UINT, true),
		);
	}
	
	public static function loginFailed(GWF_User $user)
	{
		$failure = new self(array(
			'logfail_ip' => GWF_IP6::getIP(GWF_IP_QUICK),
			'logfail_uid' => $user->getID(),
			'logfail_time' => time(),
		));
		return $failure->insert() !== false;
	}
	
	public static function getFailedData(GWF_User $user, $time)
	{
		$ip = GDO::escape(GWF_IP6::getIP(GWF_IP_EXACT));
		$cut = time() - $time;
		if (false === ($result = GDO::table(__CLASS__)->selectFirst('COUNT(*) c, MIN(logfail_time) min', "logfail_ip='$ip' AND logfail_time>$cut"))) {
			return array(0, 0);
		}
		return array((int)$result['c'], (int)$result['min']);
	}
	
	public static function getFailCount(GWF_User $user, $time)
	{
		$userid = $user->getID();
		$cut = time() - $time;
		return self::table(__CLASS__)->countRows("logfail_uid=$userid AND logfail_time>$cut");
	}
	
	public static function cleanupUser($userid)
	{
		$userid = (int) $userid;
		return self::table(__CLASS__)->deleteWhere("logfail_uid=$userid");
	}
	
	public static function cleanupCron($time)
	{
		$cut = time() - $time;
		return self::table(__CLASS__)->deleteWhere("logfail_time>$cut");
	}
}
?>