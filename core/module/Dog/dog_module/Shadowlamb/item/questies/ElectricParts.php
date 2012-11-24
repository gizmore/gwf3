<?php
final class Item_ElectricParts extends SR_QuestItem
{
	public function getItemWeight() { return 200; }
	public function getItemDescription() { return 'Electric parts used in combat drones.'; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>