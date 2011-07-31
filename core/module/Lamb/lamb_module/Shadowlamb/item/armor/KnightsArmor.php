<?php
final class Item_KnightsArmor extends SR_Armor
{
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 3150; }
	public function getItemWeight() { return 12500; }
	public function getItemDescription() { return 'A shiny and heavy knights armor. Only used for melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.15,
			'marm' => 3.5,
			'farm' => 1.3,
		);
	}
}
?>