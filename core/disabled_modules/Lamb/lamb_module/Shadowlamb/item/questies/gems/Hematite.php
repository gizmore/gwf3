<?php
final class Item_Hematite extends SR_QuestItem
{
	public function getItemLevel() { return 23; }
	public function getItemDescription() { return 'A quite large and dark hematite.'; }
	public function getItemWeight() { return 10; }
	public function getItemPrice() { return 79.95; }
	public function isItemSellable() { return true; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>