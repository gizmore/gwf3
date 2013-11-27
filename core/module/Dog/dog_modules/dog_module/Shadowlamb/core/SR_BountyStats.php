<?php
final class SR_BountyStats extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bounty_stats'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bs_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4bs_kills' => array(GDO::UINT, 0),
			'sr4bs_income' => array(GDO::UINT, 0),
		);
	}
	
	##############
	### Static ###
	##############
	public static function getBountyStats($player_id)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($player_id)))
		{
			return self::createBountyRow($player_id);
		}
		return $row;
	}
	private static function createBountyStats($player_id)
	{
		$row = new self(array(
			'sr4bo_pid' => $player_id,
			'sr4bo_kills' => 0,
			'sr4bo_income' => 0,
		));
		return false === $row->insert() ? false : $row;
	}
	
	
}
?>