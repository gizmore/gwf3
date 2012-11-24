<?php
final class Item_KnightsLegs extends SR_Legs
{
	public function getItemLevel() { return 17; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 2750; }
	public function getItemDescription() { return 'Shiny metal legs in old knight style. Look very nice in melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 1.2,
			'farm' => 0.4,
		);
	}
}
?>