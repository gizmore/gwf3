<?php
final class Item_WhiteOrchid extends SR_Item
{
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 40; }
	public function getItemDescription() { return "A mystical snow-white orchid. It is said it has magic powers."; }
	public function isItemLootable() { return false; }
}
?>
