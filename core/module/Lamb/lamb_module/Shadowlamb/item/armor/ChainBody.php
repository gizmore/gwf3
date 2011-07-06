<?php
final class Item_ChainBody extends SR_Armor
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 1250; }
	public function getItemWeight() { return 5500; }
	public function getItemDescription() { return 'A heavy chain body armor. Used in arenas for melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 1.5,
			'farm' => 1.0,
		);
	}
}
?>