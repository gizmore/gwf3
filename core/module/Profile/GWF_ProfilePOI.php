<?php
final class GWF_ProfilePOI extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'profile_pois'; }
	public function getColumnDefines()
	{
		return array(
			'pp_id' => array(GDO::AUTO_INCREMENT),
			'pp_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'pp_lat' => array(GDO::DECIMAL, GDO::NOT_NULL, array(3,8)),
			'pp_lon' => array(GDO::DECIMAL, GDO::NOT_NULL, array(3,8)),
			'pp_descr' => array(GDO::VARCHAR|GDO::CASE_I|GDO::UTF8, GDO::NULL, 128),
				
			'users' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'pp_uid', 'user_id')),
			'profiles' => array(GDO::JOIN, GDO::NULL, array('GWF_Profile', 'pp_uid', 'prof_uid')),
		);
	}
	
	public static function getPOICount($userid)
	{
		return GDO::table(__CLASS__)->countRows("pp_uid=$userid");
	}

	public static function changeAllowed($id, $userid)
	{
		return $id == 0 ? true : self::table(__CLASS__)->countRows("pp_id = $id AND pp_uid=$userid") === 1;
	}
}
