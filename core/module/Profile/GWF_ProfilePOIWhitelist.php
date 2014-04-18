<?php
final class GWF_ProfilePOIWhitelist extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'profile_poi_whitelist'; }
	public function getColumnDefines()
	{
		return array(
			'pw_uida' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'pw_uidb' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'pw_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
				
// 			'usera' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'pw_uida', 'user_id')),
			'userb' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'pw_uidb', 'user_id')),
			'country' => array(GDO::JOIN, GDO::NULL, array('GWF_Country', 'user_countryid', 'country_id')),
		);
	}
}
