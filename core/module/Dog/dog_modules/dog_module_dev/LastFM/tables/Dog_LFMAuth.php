<?php
class Dog_LFMAuth extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_lfm_auth'; }
	public function getColumnDefines()
	{
		return array(
			'lfma_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'lfma_username' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 64),
			'lfma_options' => array(GDO::UINT, 0),
		);
	}
}
