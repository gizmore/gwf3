<?php
final class Item_Hourglass extends SR_QuestItem
{
	public function getItemPrice() { return 19.95; }
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 400; }
	public function getItemDescription() { return 'A sandy hourglass ... quite fun to watch the time goes by when you are on LSD, but no fun for real runners!'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return true; }
	public function isItemLootable() { return false; }
}
?>