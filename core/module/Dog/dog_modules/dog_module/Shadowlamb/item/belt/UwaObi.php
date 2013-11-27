<?php
final class Item_UwaObi extends SR_Belt
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 29; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'This belt was worn by the samurai and their retainers in feudal Japan. It was mostly used to hold your blade.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.05,
			'max_weight' => 190,
		);
	}
}
?>
