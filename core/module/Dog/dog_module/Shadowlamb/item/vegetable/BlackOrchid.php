<?php
final class Item_BlackOrchid extends SR_Item
{
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 40; }
	public function getItemDescription() { return "A mystical black orchid. It turns white when you hand it to your true love."; }
	public function isItemLootable() { return false; }
}
?>
