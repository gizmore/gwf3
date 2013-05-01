<?php
final class Item_Robe extends SR_Armor
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 200; }
	public function getItemWeight() { return 650; }
	public function getItemDescription() { return 'A black robe for magicians or those who wanna be.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.25,
			'farm' => 0.18,
			'wisdom' => 0.3,
			'intelligence' => 0.3,
		);
	}
}
?>