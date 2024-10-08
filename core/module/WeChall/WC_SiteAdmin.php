<?php
/**
 * Map UserID to Site, to make them "site-admin"
 * @author gizmore
 */
final class WC_SiteAdmin extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_site_admin'; }
	public function getColumnDefines()
	{
		return array(
			'siteadmin_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'siteadmin_uid', 'user_id')),
			'siteadmin_sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
		);
	}
	
	###################
	### Convenience ###
	###################
	/**
	 * Get the User.
	 * @return GWF_User
	 */
	public function getUser()
	{
		return $this->getVar('siteadmin_uid');
	}
	
	public static function makeSiteAdmin($userid, $siteid)
	{
		$entry = new self(array('siteadmin_uid' => $userid,'siteadmin_sid' => $siteid));
		return $entry->replace();
	}
	
	public static function remSiteAdmin($userid, $siteid)
	{
		$userid = (int)$userid;
		$siteid = (int)$siteid;
		return self::table(__CLASS__)->deleteWhere("siteadmin_uid=$userid AND siteadmin_sid=$siteid");
	}
	
	public static function isSiteAdmin($userid, $siteid=null)
	{
		if ($siteid)
		{
			return self::table(__CLASS__)->getRow($userid, $siteid) !== false;
		}
		else
		{
			return !!self::table(__CLASS__)->selectVar("1", "siteadmin_uid=$userid");
		}
	}
	
	public static function getSiteAdmins($siteid)
	{
		return self::table(__CLASS__)->selectObjects('*', 'siteadmin_sid='.intval($siteid));
	}
}

?>