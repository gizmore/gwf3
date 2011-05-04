<?php
final class Item_Shorts extends SR_Legs
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 60; }
	public function getItemWeight() { return 450; }
	public function getItemDescription() { return 'Funky bermuda shorts.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.2,
			'farm' => 0.1,
		);
	}
}
?>