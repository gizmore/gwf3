<?php
final class Item_Sandals extends SR_Boots
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 29.95; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Some cheap sandals.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.1,
			'farm' => 0.1,
		);
	}
}
?>