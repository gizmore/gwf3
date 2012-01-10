<?php
final class Item_MilitaryCircuits extends SR_QuestItem
{
	public function getItemWeight() { return 100; }
	public function getItemDescription() { return 'Electric parts used in military combat drones.'; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
}
?>