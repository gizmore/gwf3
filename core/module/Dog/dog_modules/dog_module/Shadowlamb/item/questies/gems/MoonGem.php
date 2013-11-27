<?php
final class Item_MoonGem extends SR_QuestItem
{
	public function getItemLevel() { return 27; }
	public function getItemDescription() { return 'A tiny and rare moongem. A material that is not from this world, but from special comets which got harvested before the dark age.'; }
	public function getItemWeight() { return 5; }
	public function getItemPrice() { return 299.95; }
	public function isItemSellable() { return true; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>
