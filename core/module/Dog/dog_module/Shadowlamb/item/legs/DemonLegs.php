<?php
final class Item_DemonLegs extends SR_Legs
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 1250; }
	public function getItemDescription() { return 'Dark glowing legs. They look like they bleed.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.6,
			'farm' => 0.7,
		);
	}
}
?>
