<?php
final class Item_Trousers extends SR_Legs
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 750; }
	public function getItemDescription() { return 'Some cheaper jeans.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.4,
			'farm' => 0.2,
		);
	}
}
?>