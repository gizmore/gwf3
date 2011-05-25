<?php
final class Item_TShirt extends SR_Armor
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 14.95; }
	public function getItemWeight() { return 500; }
	public function getItemDescription() { return 'The famous wechall T-Shirt ... maybe not!'; }
//	public function isItemSellable() { return false; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.1,
			'farm' => 0.0,
		);
	}
}
?>