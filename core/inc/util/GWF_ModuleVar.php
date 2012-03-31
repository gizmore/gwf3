<?php
final class GWF_ModuleVar extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'modulevar'; }
	public function getColumnDefines()
	{
		return array(
			'mv_mid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'mv_key' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, true, 64),
			'mv_val' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 255), # 1/0
			'mv_value' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 255), # YES/non
			'mv_type' => array(GDO::ENUM, 'text', array('int','text','bool','script','time','float')),
			'mv_min' => array(GDO::INT, GDO::NULL),
			'mv_max' => array(GDO::INT, GDO::NULL),
		);
	}
}
