<?php
final class Item_Quartz extends SR_QuestItem
{
	public function getItemLevel() { return 23; }
	public function getItemDescription() { return 'A quite large and gray quartz crystal.'; }
	public function getItemWeight() { return 10; }
	public function getItemPrice() { return 169.95; }
	public function isItemSellable() { return true; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>