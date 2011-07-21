<?php
final class Item_ChainBoots extends SR_Boots
{
	public function getItemLevel() { return 8; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 1450; }
	public function getItemDescription() { return 'Heavy metal chain boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.6,
			'farm' => 0.4,
		);
	}
}
?>