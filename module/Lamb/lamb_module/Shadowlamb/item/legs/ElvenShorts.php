<?php
final class Item_ElvenShorts extends SR_Legs
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Funky green shorts.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.3,
			'farm' => 0.3,
			'quickness' => 0.3,
		);
	}
}
?>