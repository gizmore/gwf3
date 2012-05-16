<?php
final class Item_LeatherBelt extends SR_Belt
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 380; }
	public function getItemDescription() { return 'A broad leather belt. Not much additionl protection.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.05,
			'marm' => 0.1,
			'farm' => 0.1,
			'max_weight' => 500,
		);
	}
}
?>
