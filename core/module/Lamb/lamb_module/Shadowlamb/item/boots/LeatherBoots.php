<?php
final class Item_LeatherBoots extends SR_Boots
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 250; }
	public function getItemWeight() { return 750; }
	public function getItemDescription() { return 'Solid brown leather boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.3,
			'farm' => 0.3,
		);
	}
}
?>