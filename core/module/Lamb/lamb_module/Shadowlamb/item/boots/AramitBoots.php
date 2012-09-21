<?php
final class Item_AramitBoots extends SR_Boots
{
	public function getItemLevel() { return 23; }
	public function getItemPrice() { return 1450; }
	public function getItemWeight() { return 575; }
	public function isItemDropable() { return false; }
	public function getItemDescription() { return 'Aramit boots are used by military forces.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.6,
			'farm' => 1.2,
			'quickness' => 0.25,
		);
	}
}
?>