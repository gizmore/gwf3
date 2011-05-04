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
			'siteadmin_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'siteadmin_uid')),
			'siteadmin_sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
		);
	}
	
	###################
	### Convinience ###
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
	
	public static function isSiteAdmin($userid, $siteid)
	{
		return self::table(__CLASS__)->getRow($userid, $siteid) !== false;
	}
	
	public static function getSiteAdmins($siteid)
	{
		return self::table(__CLASS__)->select('siteadmin_sid='.intval($siteid));
	}
}

?>