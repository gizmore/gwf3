<?php
final class Item_IDCard extends SR_QuestItem
{
	public function getItemWeight() { return 35; }
	public function getItemDescription() { return 'A renraku ID card. You can enter the Renraku building with it.'; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>