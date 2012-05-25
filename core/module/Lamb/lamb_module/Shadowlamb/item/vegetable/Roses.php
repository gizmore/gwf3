<?php
final class Item_Roses extends SR_Item
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 20; }
	public function getItemWeight() { return 80; }
	public function getItemDescription() { return "Red roses, for the romantic runners."; }
	public function isItemLootable() { return false; }
}
?>
