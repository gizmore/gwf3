<?php
final class Item_NySoftBackup extends SR_QuestItem
{
	public function getItemPrice() { return 0; }
	public function getItemLevel() { return -1; }
	public function getItemWeight() { return 15; }
	public function getItemDescription() { return 'A virtual file on your headcomputer. The latest NySoft backup which you have to bring to Mr.Johnson in the Owls Club, Chicago.'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemSellable() { return false; }
}
?>