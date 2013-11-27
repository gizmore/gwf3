<?php
final class Item_SpikeGloves extends SR_Gloves
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 350; }
	public function getItemDescription() { return 'Hard black leather gloves with short spike shrapnells. Good assistance for close combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.2',
			'melee' => '1.0',
			'marm' => '0.2',
		);
	}
}
?>
