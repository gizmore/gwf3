<?php
final class Item_SireneSkin extends SR_Armor
{
	public function getItemLevel() { return 29; }
	public function getItemPrice() { return 1950; }
	public function getItemWeight() { return 1150; }
	public function getItemUsetime() { return 120; }
	public function getItemDropChance() { return 1.0; }
	public function getItemDescription() { return 'The skin of a Sirene. Very robust but smells a bit fishy.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 2.4,
			'marm' => 2.0,
			'farm' => 2.0,
		);
	}
}
?>
