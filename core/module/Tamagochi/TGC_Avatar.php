<?php
final class TGC_Avatar extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_avatars'; }
	public function getColumnDefines()
	{
		return array(
				'a_id' => array(GDO::PRIMARY_KEY|GDO::UNSIGNED),
				'a_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
				'a_exp' => array(GDO::UINT, 0),
				'a_hp' => array(GDO::UINT, 0),
				'a_max_hp' => array(GDO::UINT, 0),
				'a_color' => array(GDO::ENUM, 'black', TGC_Const::$COLORS),
				'a_exp_fighter' => array(GDO::INT, -1),
				'a_exp_ninja' => array(GDO::INT, -1),
				'a_exp_priest' => array(GDO::INT, -1),
				'a_exp_wizard' => array(GDO::INT, -1),
				'a_exp_earth' => array(GDO::INT, -1),
				'a_exp_fire' => array(GDO::INT, -1),
				'a_exp_water' => array(GDO::INT, -1),
				'a_exp_wind' => array(GDO::INT, -1),
				'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'p_uid', 'user_id'))
		);
	}
}
