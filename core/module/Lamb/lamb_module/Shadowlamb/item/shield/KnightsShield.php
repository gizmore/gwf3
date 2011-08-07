<?php
final class Item_KnightsShield extends SR_Shield
{
	public function getItemLevel() { return 22; }
	public function getItemPrice() { return 800; }
	public function getItemWeight() { return 2950; }
	public function getItemDescription() { return 'A shiny metal shield used by medival knights.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.8,
			'farm' => 0.7,
		);
	}
	
}
?>