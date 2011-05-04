<?php
final class WC_SiteDescr extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_site_descr'; }
	public function getColumnDefines()
	{
		return array(
//			'site_desc_sid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('WC_Site', 'site_desc_sid', 'site_id')),
			'site_desc_sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'site_desc_lid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'site_desc_txt' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
	
	public static function getAllDescr()
	{
		$browser_lid = GWF_Language::getCurrentID();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$descr = GWF_TABLE_PREFIX.'wc_site_descr';
		$db = gdo_db();
		$back = array();
		
		$query = "SELECT site_id, site_desc_txt FROM $sites JOIN $descr ON site_desc_sid=site_id WHERE site_desc_lid=$browser_lid";
		if (false === ($result = $db->queryRead($query))) {
			return array();
		}
		while (false !== ($row = $db->fetchRow($result)))
		{
			$back[(int)$row[0]] = $row[1];
		}
		$db->free($result);
		
		$query = "SELECT site_id, site_desc_txt FROM $sites JOIN $descr ON site_desc_sid=site_id WHERE site_desc_lid=site_descr_lid";
		if (false === ($result = $db->queryRead($query))) {
			return array();
		}
		while (false !== ($row = $db->fetchRow($result)))
		{
			$sid = (int)$row[0];
			if (!isset($back[$sid])) {
				$back[$sid] = $row[1];
			}
		}
		$db->free($result);
		
		return $back;
	}
	
	public static function getDescriptions($siteid)
	{
		$siteid = (int)$siteid;
		return GDO::table(__CLASS__)->selectMatrix2D('site_desc_lid', 'site_desc_txt', "site_desc_sid=$siteid");
	}
	
	public static function getDescription($siteid)
	{
		$siteid = (int)$siteid;
		$browser_lid = GWF_Language::getCurrentID();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$descr = GWF_TABLE_PREFIX.'wc_site_descr';
		$db = gdo_db();
		$query = "SELECT site_desc_lid, site_desc_txt FROM $sites JOIN $descr ON site_desc_sid=site_id WHERE site_desc_sid=$siteid AND (site_desc_lid=$browser_lid OR site_desc_lid=site_descr_lid)";
		if (false === ($result = $db->queryAll($query, false))) {
			return '';
		}
		
		if (count($result) === 2) {
			if ($result[0][0] == $browser_lid) {
				return $result[0][1];
			} else {
				return $result[1][1];
			}
		} else {
			return $result[0][1];
		}
	}
	
	public static function insertDescr($siteid, $langid, $descr)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'site_desc_sid' => $siteid,
			'site_desc_lid' => $langid,
			'site_desc_txt' => $descr,
		), true);
	}
	
	public static function deleteDescr($siteid, $langid)
	{
		$siteid = (int)$siteid;
		$langid = (int)$langid;
		$table = self::table(__CLASS__);
		if (false === ($table->deleteWhere("site_desc_sid=$siteid AND site_desc_lid=$langid"))) {
			return false;
		}
		return $table->affectedRows() === 1;
	}
	
}
?>