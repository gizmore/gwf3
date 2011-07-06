<?php
final class WC_FirstLink extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_first_link'; }
	public function getColumnDefines()
	{
		return array(
			'fili_onsitename' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'fili_sid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'fili_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_DAY),
			'fili_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'fili_username' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'fili_sitename' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'fili_percent' => array(GDO::DECIMAL|GDO::INDEX, GDO::NOT_NULL, array(3,2)),
		);
	}
	
	public static function insertFirstLink(GWF_User $user, WC_Site $site, $onsitename, $onsitescore)
	{
		$table = self::table(__CLASS__);
		$siteid = $site->getVar('site_id');
		if (false !== ($table->getRow($onsitename, $siteid))) {
			return true;
		}
		
		$entry = new self(array(
			'fili_onsitename' => $onsitename,
			'fili_sid' => $siteid,
			'fili_date' => GWF_Time::getDate(GWF_Date::LEN_DAY),
			'fili_uid' => $user->getVar('user_id'),
			'fili_username' => $user->getVar('user_name'),
			'fili_sitename' => $site->getVar('site_name'),
			'fili_percent' => $site->getPercent($onsitescore),
		));
		
//		echo GWF_HTML::message('DEBUG', 'Insert First Link...');
		
		return $entry->insert();
	}
}
?>