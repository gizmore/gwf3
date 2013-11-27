<?php
final class Item_ElvenBoots extends SR_Boots
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 200; }
	public function getItemDescription() { return 'Green elven boots. They glow slightly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.2,
			'farm' => 0.2,
			'quickness' => 0.2,
		);
	}
}
?>