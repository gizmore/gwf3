<?php
final class SR_Stats extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_stats'; }
	public function getColumnDefines()
	{
		return array(
			'sr4st_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4st_commands' => array(GDO::UINT, 0),
			'sr4st_killed' => array(GDO::UINT, 0),
			'sr4st_died' => array(GDO::UINT, 0),
			'sr4st_fled' => array(GDO::UINT, 0),
			'sr4st_money' => array(GDO::UINT, 0),
			'sr4st_items' => array(GDO::UINT, 0),
			'sr4st_sell' => array(GDO::UINT, 0),
			'sr4st_buy' => array(GDO::UINT, 0),
		);
	}
	
	public static function deletePlayer(SR_Player $player)
	{
		return self::table(__CLASS__)->deleteWhere('sr4st_pid='.$player->getID());
	}
	
	
}
?>