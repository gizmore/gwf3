<?php
final class Item_IlonasRing extends SR_Ring
{
	public function getItemLevel() { return 25; }
	public function getItemPrice() { return 4000; }

	public function isItemDropable() { return false; }
	public function isItemLootable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'orcas' => 2,
			'casting' => 3,
			'charisma' => 4,
		);
	}
}
?>
