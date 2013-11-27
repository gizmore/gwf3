<?php
final class Item_Shovel extends SR_Item
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 95.99; }
	public function getItemWeight() { return 1270; }
	public function getItemDescription() { return "A light aluminium shovel. You wonder if you would ever need it during your journey."; }
	public function isItemLootable() { return false; }
}
?>
