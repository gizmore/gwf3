<?php
final class Item_DemonBoots extends SR_Boots
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 1150; }
	public function getItemWeight() { return 525; }
	public function getItemDescription() { return 'Dark glowing boots. They look like they are bleeding.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.6,
			'farm' => 0.9,
		);
	}
}
?>