<?php
final class SR_BazarWTB extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bazar_wtb'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bb_id' => array(GDO::AUTO_INCREMENT),
			'sr4bb_pname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'sr4bb_iname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'sr4bb_price' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4bb_iamt' => array(GDO::UINT, 1),
		);
	}
	
	public static function getItemcountForPlayer(SR_Player $player)
	{
		return self::table(__CLASS__)->selectVar('COUNT(*)', "sr4bb_pname='{$player->getName()}'");
	}
	
	public static function getItemsForPlayer(SR_Player $player)
	{
		$table = self::table(__CLASS__);
		$back = array();
		if (false === ($result = $table->select('*', "sr4bb_pname='{$player->getName()}'", 'sr4bb_time ASC')))
		{
			return $back;
		}
		while (false !== ($data = $table->fetch($result)))
		{
			$item = SR_Item::createByName($data['sr4bb_iname'], $data['sr4bb_iamt'], false);
			$item->setVar('bwtb_price', $data['sr4bb_price']);
			$back[] = $item;
		}
		$table->free($result);
		return $back;
	}

	public static function insertEntry(SR_Player $player, SR_Item $item, $price)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4bb_id' => 0,
			'sr4bb_pname' => $player->getName(),
			'sr4bb_iname' => $item->getName(),
			'sr4bb_price' => $price,
			'sr4bb_iamt' => $item->getAmount(),
		));
	}
}
?>
