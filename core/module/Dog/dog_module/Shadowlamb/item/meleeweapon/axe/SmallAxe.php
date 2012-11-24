<?php
final class Item_SmallAxe extends SR_Axe
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 2; }
	public function getItemWeight() { return 1600; }
	public function getItemPrice() { return 45; }
	public function getItemRange() { return 1.4; }
	public function getItemDescription() { return 'A small axe to cut small pieces of wood occsassionally.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4.0, 
			'min_dmg' => 1.0,
			'max_dmg' => 8.0,
		);
	}
}
?>