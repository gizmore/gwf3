<?php
final class Item_StuddedVest extends SR_Armor
{
	public function getItemLevel() { return 7; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 2500; }
	public function getItemDescription() { return 'A studded leather vest. A bit more protection than a leather vest.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.7,
			'farm' => 0.6,
		);
	}
}
?>