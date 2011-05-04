<?php
/**
 * Map UserID to SiteID, for selection of favorite sites.
 * These will get displayed in a user specific dropdown, to access your favorite sites.
 * @author gizmore
 */
final class WC_SiteFavorites extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_site_favs'; }
	public function getColumnDefines()
	{
		return array(
			'sitefav_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sitefav_sid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('WC_Site', 'sitefav_sid')),
		);
	}
	
	###################
	### Convinience ###
	###################
	public static function setFavorite($userid, $siteid, $bool)
	{
		$entry = new self(array(
			'sitefav_uid' => $userid,
			'sitefav_sid' => $siteid,
		));
		
		if ($bool === true) {
			return $entry->replace();
		} else {
			return $entry->delete();
		}
	}
	
//	public static function isFavorite($userid, $siteid)
//	{
//		return self::table(__CLASS__)->selectFirst("sitefav_uid=$userid AND sitefav_sid=$siteid") !== false;
//	}
	
	public static function getFavoriteSites($userid)
	{
		$userid = (int) $userid;
		$favs = GWF_TABLE_PREFIX.'wc_site_favs';
		return self::table('WC_Site')->select("(IF((SELECT 1 FROM $favs WHERE sitefav_sid=site_id AND sitefav_uid=$userid), 1, 0))", 'site_name ASC');
	}
	
	public static function getNonFavoriteSites($userid)
	{
		$userid = (int) $userid;
		$favs = GWF_TABLE_PREFIX.'wc_site_favs';
		return self::table('WC_Site')->select("(IF((SELECT 1 FROM $favs WHERE sitefav_sid=site_id AND sitefav_uid=$userid), 0, 1))", 'site_name ASC');
	}
	
}

?>