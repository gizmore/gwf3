<?php
final class Item_Bolete extends SR_Item
{
	public function getItemLevel() { return 24; }
	public function getItemPrice() { return 10; }
	public function getItemWeight() { return 10; }
	public function getItemDescription() { return "A big brown mushroom. Edible and maybe even useful for alchemy."; }
	public function isItemLootable() { return false; }
}
?>
