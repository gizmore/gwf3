<?php
final class Item_WeChallShirt extends SR_Armor
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 14.95; }
	public function getItemWeight() { return 500; }
	public function getItemDescription() { return 'The famous wechall T-Shirt!'; }
//	public function isItemSellable() { return false; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.3,
			'farm' => 0.3,
			'intelligence' => 2.5,
			'wisdom' => 2.5,
		);
	}
}
?>