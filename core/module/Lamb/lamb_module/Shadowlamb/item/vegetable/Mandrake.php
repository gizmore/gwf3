<?php
final class Item_Mandrake extends SR_Item
{
	public function getItemLevel() { return 21; }
	public function getItemPrice() { return 19.95; }
	public function getItemWeight() { return 50; }
	public function getItemDescription() { return "A magic herb which is needed to brew magic potions."; }
	public function isItemDropable() { return true; }
	public function isItemSellable() { return true; }
	public function isItemTradeable() { return true; }
	public function isItemLootable() { return true; }
}
?>