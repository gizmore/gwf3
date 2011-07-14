<?php
final class Item_ElvenShield extends SR_Shield
{
	public function getItemLevel() { return 11; }
	public function getItemPrice() { return 900; }
	public function getItemWeight() { return 950; }
	public function getItemDescription() { return 'A light and small shield, made by woodelves.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.2,
			'magic' => 0.3,
			'intelligence' => 0.5,
		);
	}
	
}
?>