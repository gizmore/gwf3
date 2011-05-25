<?php
final class Item_LeatherLegs extends SR_Legs
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 120; }
	public function getItemWeight() { return 1150; }
	public function getItemDescription() { return 'Brown and quite heavy leather trousers.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.5,
			'farm' => 0.3,
		);
	}
}
?>