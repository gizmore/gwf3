<?php
final class Item_Emerald extends SR_QuestItem
{
	public function getItemDescription() { return 'A quite large and green emerald.'; }
	public function getItemWeight() { return 10; }
	public function getItemPrice() { return 179.95; }
	public function isItemSellable() { return true; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>