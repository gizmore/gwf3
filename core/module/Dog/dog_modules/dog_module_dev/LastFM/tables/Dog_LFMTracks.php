<?php
class Dog_LFMTracks extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_lfm_tracks'; }
	public function getColumnDefines()
	{
		return array(
			'lfmt_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'lfmt_track' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
		);
	}
}
