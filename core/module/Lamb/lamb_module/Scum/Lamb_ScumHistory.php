<?php
final class Lamb_ScumHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_scum_history'; }
	public function getColumnDefines()
	{
		return array(
			'scumh_id' => array(GDO::AUTO_INCREMENT),
			'scumh_server' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'scumh_channel' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'scumh_players' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I), # csv
			'scumh_order' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I), # csv
			'scumh_cards' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I), # ,sv ;sv
			'scumh_winners' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
}
?>