<?php
final class Item_ChainLegs extends SR_Legs
{
	public function getItemLevel() { return 7; }
	public function getItemPrice() { return 920; }
	public function getItemWeight() { return 2250; }
	public function getItemDescription() { return 'Heave chain legs. High melee protection but hard to move when wearing that.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => -0.5,
			'marm' => 1.8,
			'farm' => 0.7,
		);
	}
}
?>