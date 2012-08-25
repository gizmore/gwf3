<?php
final class Item_TShirt extends SR_Armor
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 13.95; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'The famous wechall T-Shirt ... Maybe not!'; }
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