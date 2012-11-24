<?php
final class Item_SatinGloves extends SR_Gloves
{
	public function getItemLevel() { return 3; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 90; }
	public function getItemDescription() { return 'Thin satin gloves which don´t leave a fingerprint.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.1',
			'thief' => '2.0',
			'quickness' => '0.1',
		);
	}
}
?>
