<?php
final class Item_BattleAxe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 2350; }
	public function getItemPrice() { return 275; }
	public function getItemRange() { return 2.8; }
	public function getItemDescription() { return 'A two sided large and heave battle axe. Dwarf anyone?'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 3.0, 
			'min_dmg' => 4.5,
			'max_dmg' => 12.0,
		);
	}
}
?>