<?php
final class Item_MagicOil extends SR_Item
{
	public function isItemLootable() { return false; }
	public function getItemLevel() { return 25; }
	public function getItemPrice() { return 300; }
	public function getItemWeight() { return 120; }
	public function getItemDescription() { return "A magic thick fluid that prevents items from breaking during blackmsith via #safe-upgrade."; }
}
?>
