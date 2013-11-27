<?php
final class Item_Fur extends SR_QuestItem
{
	public function getItemWeight() { return 1400; }
	public function getItemDescription() { return 'Big and bloody fur from killing a bear. Quite gross to most people but you got used to the gore.'; }
	public function isItemDropable() { return true; }
	public function isItemSellable() { return true; }
	public function isItemTradeable() { return true; }
	public function getItemPrice() { return 149; }
}
?>
