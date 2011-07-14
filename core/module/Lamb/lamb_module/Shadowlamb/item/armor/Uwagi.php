<?php
final class Item_Uwagi extends SR_Armor
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 1800; }
	public function getItemUsetime() { return 90; }
	public function getItemDescription() { return 'A dark ninja jacket.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.0,
			'quickness' => 0.5,
			'marm' => 0.7,
			'farm' => 0.7,
		);
	}
	
}
?>