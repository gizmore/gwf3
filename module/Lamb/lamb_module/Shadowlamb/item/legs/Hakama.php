<?php
final class Item_Hakama extends SR_Legs
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 3749; }
	public function getItemWeight() { return 650; }
	public function getItemDescription() { return 'Very light ninja legs. High defense, but not much armor.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.4,
			'farm' => 0.4,
			'quickness' => 0.2,
		);
	}
}
?>