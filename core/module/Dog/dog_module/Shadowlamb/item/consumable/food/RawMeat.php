<?php
final class Item_RawMeat extends SR_Item
{
	public function getItemLevel() { return -1; }
	public function getItemDescription() { return 'Two pounds of raw meat... It`s grill season in every season!'; }
	public function getItemWeight() { return 1000; }
	public function getWater() { return 250; }
	public function getCalories() { return 2500; }
	public function getItemPrice() { return 9.95; }
}
?>