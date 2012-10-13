<?php
final class Item_Pike extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 1750; }
	public function getItemPrice() { return 175; }
	public function getItemRange() { return 5.0; }
	public function getItemDescription() { return 'An ancient looking pike. Maybe nice for ranged melee.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 6.0, 
			'min_dmg' => 3.5,
			'max_dmg' => 7.0,
		);
	}
}
?>