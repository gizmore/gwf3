<?php
final class Item_AramitLegs extends SR_Legs
{
	public function isItemLootable() { return false; }
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 1450; }
	public function getItemWeight() { return 1250; }
	public function getItemDescription() { return 'Military grade aramit leg protection.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.35,
			'marm' => 0.6,
			'farm' => 0.8,
		);
	}
}
?>