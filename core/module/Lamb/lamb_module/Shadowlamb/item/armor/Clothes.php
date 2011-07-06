<?php
final class Item_Clothes extends SR_Armor
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 100; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Usual street clothes.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.1,
		);
	}
}
?>