<?php
final class Item_ConvictVest extends SR_Armor
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 45; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Prisoner clothes.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.1,
		);
	}
}
?>