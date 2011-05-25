<?php
final class Item_Rune extends SR_Rune
{
	public function getItemLevel() { return 4; }
	public function getItemDropChance() { return 50.00; }
	public function getItemPrice() { return 100; }
	public function getItemDescription() { return 'A rune to upgrade equipment at a blacksmith.'; }
	public function getItemWeight() { return 150; }
}
?>