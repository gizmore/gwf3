<?php
final class Item_Roses extends SR_Item
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 20; }
	public function getItemDescription() { return "Red roses, for the romantic runners."; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return true; }
	public function isItemTradeable() { return true; }
	public function isItemLootable() { return false; }
}
?>