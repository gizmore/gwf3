<?php
final class Item_KnightsBoots extends SR_Boots
{
	public function getItemLevel() { return 15; }
	public function getItemPrice() { return 850; }
	public function getItemWeight() { return 1750; }
	public function getItemDescription() { return 'Heavy shiny knight boots. Impressive for melee.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.9,
			'farm' => 0.3,
		);
	}
}
?>