<?php
final class SR_ClanMembers extends GDO
{
	const FOUNDER = 0x01;
	const RECRUITER = 0x02;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_members'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cm_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cm_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cm_options' => array(GDO::UINT, 0),
		);
	}
	
}
?>