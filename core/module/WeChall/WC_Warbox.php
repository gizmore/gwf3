<?php
final class WC_Warbox extends GDO
{
	public static $STATUS = array('up', 'down', 'dead');
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warbox'; }
	public function getColumnDefines()
	{
		return array(
			'wb_id' => array(GDO::AUTO_INCREMENT),
			'wb_sid' => array(GDO::UINT, GDO::NOT_NULL),

			'wb_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, '', 31),
			'wb_levels' => array(GDO::MEDIUMINT, -1),
			'wb_port' => array(GDO::UMEDIUMINT, 113),
			'wb_host' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 255),
			'wb_user' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '',  63),
			'wb_pass' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '',  63),
			'wb_weburl' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_ip' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, '',  63),
			'wb_whitelist' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_blacklist' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_launched_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_DAY),
				
			'wb_created_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'wb_updated_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'wb_status' => array(GDO::ENUM, 'up', self::$STATUS),
				
			# JOIN
			'sites' => array(GDO::JOIN, GDO::NULL, array('WC_Site', 'site_id', 'wb_sid')),
		);
	}
	
	public function getID() { return $this->getVar('wb_id'); }
	public function getSite() { return new WCSite_WARBOX($this->gdo_data); }
	public function getSiteID() { return $this->getVar('wb_sid'); }
	public function hrefEdit() { return sprintf('index.php?mo=WeChall&me=Warboxes&siteid=%s&edit=%s', $this->getSiteID(), $this->getID()); }

	public function displayLink()
	{
		if ('' === ($url = $this->getVar('wb_weburl')))
		{
			return $this->display('wb_host');
		}
		return GWF_HTML::anchor($url, $this->getVar('wb_host'));
	}
	
	public function displayLevels()
	{
		if (0 > ($levels = $this->getVar('wb_levels')))
		{
			return '??';
		}
		return $levels;
	}
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->selectFirstObject('*', sprintf('wb_id=%d', $id));
	}
	
	public static function getByIDs($id, $siteid)
	{
		$where = sprintf('wb_id=%d AND wb_sid=%d', $id, $siteid);
		return self::table(__CLASS__)->selectFirstObject('*', $where);
	}
	
	public static function getBoxes(WC_Site $site)
	{
		return self::getAllBoxes('wb_sid='.$site->getID());
	}
	
	public static function getAllBoxes($where='', $orderby='')
	{
		return self::table(__CLASS__)->selectAll('*', $where, $orderby, NULL, -1, -1, GDO::ARRAY_O);
	}
}
?>
