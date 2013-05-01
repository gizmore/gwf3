<?php
final class Item_DataCrystal extends SR_QuestItem
{
	public function getItemPrice() { return 9.95; }
	public function getItemLevel() { return -1; }
	public function getItemWeight() { return 35; }
	public function getItemDescription() { return 'A data crystal you have to show around ... scary!'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return false; }
}
?>