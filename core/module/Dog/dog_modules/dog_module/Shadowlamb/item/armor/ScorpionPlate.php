<?php
final class Item_ScorpionPlate extends SR_Armor
{
	public function getItemLevel() { return 34; }
	public function getItemPrice() { return 1250; }
	public function getItemWeight() { return 1350; }
	public function getItemUsetime() { return 120; }
	public function getItemDropChance() { return 2.0; }
	public function getItemDescription() { return 'The strong back armor plate of a scorpion.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 2.2,
			'marm' => 2.5,
			'farm' => 1.9,
		);
	}
}
?>
