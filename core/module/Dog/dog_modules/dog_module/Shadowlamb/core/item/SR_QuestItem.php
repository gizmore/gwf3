<?php
abstract class SR_QuestItem extends SR_Item
{
	public function getItemDuration() { return -1; } # unlimited.
	public function displayType() { return 'Quest Item'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return false; }
}
?>
