<?php
final class Item_LargeShield extends SR_Shield
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 900; }
	public function getItemWeight() { return 1900; }
	public function getItemDescription() { return 'A nice ornamented shield, made by orks.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.5,
			'farm' => 0.4,
		);
	}
}
?>