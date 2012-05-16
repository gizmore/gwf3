<?php
final class Item_HardGloves extends SR_Gloves
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 320; }
	public function getItemDescription() { return 'Black thick leather gloves. Still good enough grip for melee weapons.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.1',
			'melee' => '0.1',
			'marm' => '0.2',
		);
	}
}
?>
