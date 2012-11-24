<?php
final class Item_DornGloves extends SR_Gloves
{
	public function getItemLevel() { return 12; }
	public function getItemPrice() { return 119; }
	public function getItemWeight() { return 500; }
	public function getItemDescription() { return 'Hard black leather gloves with long dorns for your knuckles. Deadly assistance for close combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.2',
			'melee' => '1.5',
			'marm' => '0.3',
			'farm' => '0.1',
		);
	}
}
?>
