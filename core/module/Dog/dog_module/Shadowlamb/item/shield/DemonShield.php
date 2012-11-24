<?php
final class Item_DemonShield extends SR_Shield
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 1200; }
	public function getItemWeight() { return 1850; }
	public function getItemDescription() { return 'A large protective shield. It glows dark and seems like it is bleeding.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.7,
			'farm' => 0.8,
		);
	}
}
?>
