<?php
final class Item_ElectronicParts extends SR_QuestItem
{
	public function getItemWeight() { return 500; }
	public function getItemDescription() { return 'Electronic parts used in cyberwar.'; }
	public function isItemDropable() { return false; }
	public function isItemTradeable() { return false; }
}
?>