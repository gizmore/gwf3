<?php
final class Item_Pizza extends SR_Item
{
	public function getItemLevel() { return 23; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 350; }
	public function getItemDescription() { return "Pizza Speciale with all you need, also bacon."; }
	public function isItemDropable() { return true; }
	public function isItemSellable() { return true; }
	public function isItemTradeable() { return true; }
	public function isItemLootable() { return true; }
}
?>