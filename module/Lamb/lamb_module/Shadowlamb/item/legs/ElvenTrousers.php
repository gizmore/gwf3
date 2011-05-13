<?php
final class Item_ElvenTrousers extends SR_Legs
{
	public function getItemLevel() { return 8; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Elven Trousers. Light and better defense, but less armor. They glow slightly green.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.7,
			'marm' => 0.4,
			'farm' => 0.2,
			'intelligence' => 0.2,
		);
	}
}
?>