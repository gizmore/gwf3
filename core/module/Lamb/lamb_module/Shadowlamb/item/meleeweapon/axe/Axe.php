<?php
final class Item_Axe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 45; }
	public function getItemLevel() { return 9; }
	public function getItemWeight() { return 1850; }
	public function getItemPrice() { return 975; }
	public function getItemRange() { return 4.0; }
	public function getItemDescription() { return 'An ancient looking axe. Maybe fun for melee.'; }
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