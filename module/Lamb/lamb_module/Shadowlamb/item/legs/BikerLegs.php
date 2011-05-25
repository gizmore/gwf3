<?php
final class Item_BikerLegs extends SR_Legs
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 350; }
	public function getItemWeight() { return 1450; }
	public function getItemDescription() { return 'Biker legs. Nice for riding a motorbike.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.8,
			'farm' => 0.4,
		);
	}
}
?>