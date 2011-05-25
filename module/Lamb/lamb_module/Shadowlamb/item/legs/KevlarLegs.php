<?php
final class Item_KevlarLegs extends SR_Legs
{
	public function getItemLevel() { return 15; }
	public function getItemPrice() { return 4950; }
	public function getItemWeight() { return 1350; }
	public function getItemDescription() { return 'Kevlar Protective Legs from Renraku. Not too bad.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.7,
			'farm' => 0.6,
		);
	}
}
?>