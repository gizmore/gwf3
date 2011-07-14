<?php
final class Item_FineRobe extends SR_Armor
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 800; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'A fine black robe for magicians or those who wanna be.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.5,
			'farm' => 0.4,
			'wisdom' => 0.8,
			'intelligence' => 0.8,
		);
	}
}
?>