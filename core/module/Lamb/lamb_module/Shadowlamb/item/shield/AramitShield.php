<?php
final class Item_AramitShield extends SR_Shield
{
	public function getItemLevel() { return 25; }
	public function isItemDropable() { return false; }
	public function getItemPrice() { return 1600; }
	public function getItemWeight() { return 1850; }
	public function getItemDescription() { return 'A large protective aramit shield, used by the military.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.8,
			'farm' => 0.9,
		);
	}
}
?>