<?php

final class GWF_VoteMultiOpt extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'vote_multi_opt'; }
	public function getColumnDefines()
	{
		return array(
			'vmo_vmid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'vmo_vmoid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),

			'vmo_text' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'vmo_votes' => array(GDO::UINT, 0),
		
			'votemulti' => array(GDO::JOIN, NULL, array('GWF_VoteMulti', 'vmo_vmid', 'vm_id')),
		);
	}
}

?>