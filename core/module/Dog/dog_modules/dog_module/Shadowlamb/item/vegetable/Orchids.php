<?php
final class Item_Orchids extends SR_Item
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 20; }
	public function getItemWeight() { return 200; }
	public function getItemDescription() { return "Orchids, for runners who fell in love."; }
	public function isItemLootable() { return false; }
}
?>
