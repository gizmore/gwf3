<?php
final class Item_FineLegs extends SR_Legs
{
	public function getItemLevel() { return 18; }
	public function getItemPrice() { return 9550; }
	public function getItemWeight() { return 250; }
	public function getItemDropChance() { return 1.00; }
	public function getItemDescription() { return 'Fine legs with a magic protection and aura. Quite expensive.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.4,
			'farm' => 0.4,
			'intelligence' => 0.5,
			'wisdom' => 0.5,
			'magic' => 0.5,
			'max_mp' => 2.5,
			'max_hp' => 1.5,
		);
	}
}
?>