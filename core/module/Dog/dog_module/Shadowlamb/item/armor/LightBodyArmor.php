<?php
final class Item_LightBodyArmor extends SR_Armor
{
	public function getItemLevel() { return 30; }
	public function getItemPrice() { return 2500; }
	public function getItemWeight() { return 5500; }
	public function getItemDescription() { return 'A protective body suite, used by tactical commandos.'; }
	public function getItemUsetime() { return 180; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.5,
			'marm' => 3.0,
			'farm' => 2.5,
		);
	}
}
?>