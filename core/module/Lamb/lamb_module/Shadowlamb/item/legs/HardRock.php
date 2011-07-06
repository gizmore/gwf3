<?php
final class Item_HardRock extends SR_Legs
{
	public function getItemLevel() { return 6; }
	public function getItemPrice() { return 169.95; }
	public function getItemWeight() { return 1200; }
	public function getItemDescription() { return 'A hardened skirt, used by female ninja assasins. Oh and it\'s red, real good purchase.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.5,
			'farm' => 0.35,
		);
	}
}
?>