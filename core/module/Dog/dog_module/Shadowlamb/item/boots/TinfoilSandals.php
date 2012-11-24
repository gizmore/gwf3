<?php
final class Item_TinfoilSandals extends SR_Boots
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 19.95; }
	public function getItemWeight() { return 300; }
	public function getItemDescription() { return 'Some cheap sandals wrapped in tinfoil. Together with a TinfoilCap you give a great capacitor.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.05,
			'marm' => 0.1,
			'farm' => 0.15,
		);
	}
}
?>