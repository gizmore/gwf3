<?php
final class Item_ID4Card extends SR_QuestItem
{
	public function getItemWeight() { return 35; }
	public function getItemDescription() { return 'A renraku ID card, level 4, useful for the upper etages of the Renraku building in Seattle.'; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>