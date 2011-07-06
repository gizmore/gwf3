<?php
final class Item_CopShield extends SR_Shield
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return -1; }
	public function getItemWeight() { return 1850; }
	public function getItemDescription() { return 'A bigger cop shield. Not a riot shiel, but still protective.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.8,
			'farm' => 0.5,
		);
	}
	
}
?>