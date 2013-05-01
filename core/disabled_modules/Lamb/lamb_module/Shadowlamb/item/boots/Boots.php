<?php
final class Item_Boots extends SR_Boots
{
	public function getItemLevel() { return 3; }
	public function getItemPrice() { return 80; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Nice brown boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.3,
			'farm' => 0.3,
		);
	}
}
?>