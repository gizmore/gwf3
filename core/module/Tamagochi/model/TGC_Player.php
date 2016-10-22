<?php
final class TGC_Player extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_players'; }
	public function getColumnDefines()
	{
		return array(
			'p_uid' => array(GDO::PRIMARY_KEY|GDO::UNSIGNED),
			'p_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'p_active_avatar' => array(GDO::UINT, GDO::NULL),
			'p_active_color' => array(GDO::ENUM, TGC_Globals::BLACK, TGC_Const::$COLORS),
			'p_active_element' => array(GDO::ENUM, TGC_Globals::EARTH, TGC_Const::$ELEMENTS),
			'p_active_skill' => array(GDO::ENUM, TGC_Globals::FIGHTER, TGC_Const::$SKILLS),
			'p_active_mode' => array(GDO::ENUM, TGC::DEFEND, TGC_Const::$MODES),
			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'p_uid', 'user_id')),
			'avatar' => array(GDO::JOIN, GDO::NOT_NULL, array('TGC_AVATAR', 'p_active_avatar', 'a_id')),
		);
	}
	
	public function rehash
	{
		
	}
}
