<?php
final class Item_FineBoots extends SR_Boots
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 4750; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'Fine boots with a magic protection. Quite expensive.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.3,
			'farm' => 0.3,
			'intelligence' => 0.6,
		);
	}
}
?>