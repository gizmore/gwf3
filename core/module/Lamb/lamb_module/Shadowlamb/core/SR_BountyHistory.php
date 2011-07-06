<?php
final class SR_BountyHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bounty_hist'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bh_id' => array(GDO::AUTO_INCREMENT),
			'sr4bh_killer_id' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4bh_bounty_id' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4bh_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
	
	public static function onKilled(SR_Player $killer, SR_Player $victim)
	{
		
	}
}
?>
