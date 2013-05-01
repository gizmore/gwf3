<?php
final class Item_ElvenRobe extends SR_Armor
{
	public function getItemLevel() { return 6; }
	public function getItemPrice() { return 1100; }
	public function getItemWeight() { return 325; }
	public function getItemDescription() { return 'Looks like a white robe for magicians. It glows light green a bit.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.4,
			'farm' => 0.3,
			'wisdom' => 0.4,
			'intelligence' => 0.4,
			'quickness' => 0.2,
		);
	}
}
?>