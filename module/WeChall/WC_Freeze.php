<?php
/**
 * Frozen accounts.
 * @author gizmore
 */
final class WC_Freeze extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_freeze'; }
	public function getColumnDefines()
	{
		return array(
			'wcf_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'wcf_uid')),
			'wcf_sid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('WC_Site', 'wcf_sid')),
		);
	}
	
	/**
	 * Check if a user is frozen at least on one site.
	 * @param int $userid
	 * @return boolean
	 */
	public static function isUserFrozen($userid)
	{
		$userid = (int)$userid;
		return self::table(__CLASS__)->countRows("wcf_uid=$userid") > 0;
	}
	
	/**
	 * Check if a user is frozen on a particular site.
	 * @param unknown_type $userid
	 * @param unknown_type $siteid
	 * @return unknown_type
	 */
	public static function isUserFrozenOnSite($userid, $siteid)
	{
		$userid = (int)$userid;
		$siteid = (int)$siteid;
		return self::table(__CLASS__)->countRows("wcf_uid=$userid AND wcf_sid=$siteid") > 0;
	}
	
	/**
	 * Insert a freeze row.
	 * @param int $userid
	 * @param int $siteid
	 * @return boolean
	 */
	public static function freezeUser($userid, $siteid)
	{
		$row = new self(array(
			'wcf_uid' => $userid,
			'wcf_sid' => $siteid,
		));
		return $row->replace();
	}
	
	public static function unfreezeUser($userid, $siteid)
	{
		$userid = (int)$userid;
		$siteid = (int)$siteid;
		return self::table(__CLASS__)->deleteWhere("wcf_uid=$userid AND wcf_sid=$siteid");
	}
	
	##################
	### Convinient ###
	##################
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getVar('wcf_uid'); }
	
	/**
	 * @return WC_Site
	 */
	public function getSite() { return $this->getVar('wcf_sid'); }
}

?>
