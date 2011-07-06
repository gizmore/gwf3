<?php
/**
 * Store join requests and invitations.
 * @author gizmore
 */
final class GWF_UsergroupsInvite extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'ug_invite'; }
	public function getColumnDefines()
	{
		return array(
			'ugi_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'ugi_gid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'ugi_type' => array(GDO::ENUM, GDO::NOT_NULL, array('invite', 'request', 'denied')),
			'ugi_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}

	private static function store($userid, $groupid, $type)
	{
		$entry = new self(array(
			'ugi_uid' => $userid,
			'ugi_gid' => $groupid,
			'ugi_type' => $type,
			'ugi_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		return $entry->replace();
	}
	
	public static function invite($userid, $groupid)
	{
		return self::store($userid, $groupid, 'invite');
	}
	
	public static function request($userid, $groupid)
	{
		return self::store($userid, $groupid, 'request');
	}
	
	public static function countInvites($groupid)
	{
		return self::count(intval($groupid), 'invite');
	}
	
	public static function countRequests($groupid)
	{
		return self::count(intval($groupid), 'request');
	}
	
	private static function count($groupid, $type)
	{
		return self::table(__CLASS__)->countRows("ugi_gid=$groupid AND ugi_type='$type'");
	}
	
	/**
	 * @param $userid
	 * @param $groupid
	 * @return GWF_UsergroupsInvite
	 */
	public static function getInviteRow($userid, $groupid)
	{
		return self::getTypeRow($userid, $groupid, 'invite');
	}
	
	/**
	 * @param $userid
	 * @param $groupid
	 * @return GWF_UsergroupsInvite
	 */
	public static function getRequestRow($userid, $groupid)
	{
		return self::getTypeRow($userid, $groupid, 'request');
	}
	
	private static function getTypeRow($userid, $groupid, $type)
	{
		$userid = (int) $userid;
		$groupid = (int) $groupid;
		return self::table(__CLASS__)->selectFirst("ugi_uid=$userid AND ugi_gid=$groupid AND ugi_type='$type'");
	}
	
	public function deny()
	{
		return $this->saveVar('ugi_type', 'denied');
	}
}

?>