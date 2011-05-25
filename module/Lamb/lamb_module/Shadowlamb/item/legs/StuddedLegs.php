<?php
final class Item_StuddedLegs extends SR_Legs
{
	public function getItemLevel() { return 3; }
	public function getItemPrice() { return 150; }
	public function getItemWeight() { return 1300; }
	public function getItemDescription() { return 'Dark studded leather legs. Bikers heaven.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.6,
			'farm' => 0.4,
		);
	}
}
?>