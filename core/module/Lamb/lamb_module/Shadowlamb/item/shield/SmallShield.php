<?php
final class Item_SmallShield extends SR_Shield
{
	public function getItemLevel() { return 6; }
	public function getItemPrice() { return 600; }
	public function getItemWeight() { return 1100; }
	public function getItemDescription() { return 'A nice ornamented small shield, made by orks.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
	
}
?>