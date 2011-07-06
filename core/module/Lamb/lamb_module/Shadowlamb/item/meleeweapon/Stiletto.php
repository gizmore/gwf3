<?php
final class Item_Stiletto extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 2; }
	public function getItemWeight() { return 350; }
	public function getItemPrice() { return 175; }
	public function getItemRange() { return 0.9; }
	public function getItemDescription() { return 'A surgical instrument. Actually not made for combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 2.1, 
			'min_dmg' => 2.0,
			'max_dmg' => 6.5,
		);
	}
}
?>