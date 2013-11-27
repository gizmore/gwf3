<?php
final class Item_DemonGloves extends SR_Gloves
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 159; }
	public function getItemWeight() { return 400; }
	public function getItemDescription() { return 'Hard red leather gloves with long dorns for your knuckles. They look like they bleed.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '1.0',
			'melee' => '1.8',
			'marm' => '0.35',
			'farm' => '0.15',
		);
	}
}
?>
