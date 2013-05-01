<?php
final class Item_BikerBelt extends SR_Belt
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 380; }
	public function getItemDescription() { return 'A broad motorbike belt to protect your kidney.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.1,
			'max_weight' => 200,
		);
	}
}
?>
