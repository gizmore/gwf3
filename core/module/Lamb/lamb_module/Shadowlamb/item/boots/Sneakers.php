<?php
final class Item_Sneakers extends SR_Boots
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Some Nike sneakers.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
}
?>