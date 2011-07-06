<?php
final class Item_BikerJacket extends SR_Armor
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 750; }
	public function getItemWeight() { return 2500; }
	public function getItemDescription() { return 'A fat biker jacket. It reads "Hell or Angel".'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 1.4,
			'farm' => 0.8,
		);
	}
}
?>