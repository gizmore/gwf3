<?php
final class Item_KevlarBoots extends SR_Boots
{
	public function getItemLevel() { return 17; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 550; }
	public function getItemDescription() { return 'Hard Kevlar boots. Very  nice for combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.5,
			'farm' => 0.7,
			'quickness' => 0.2,
		);
	}
}
?>