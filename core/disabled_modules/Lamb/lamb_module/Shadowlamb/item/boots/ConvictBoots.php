<?php
final class Item_ConvictBoots extends SR_Boots
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 80; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Prisoner boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.5,
			'farm' => 0.2,
		);
	}
}
?>