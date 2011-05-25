<?php
final class Item_Shoes extends SR_Boots
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 59.95; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Ok. Shoes for every oppurtunity.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
}
?>