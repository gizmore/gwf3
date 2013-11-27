<?php
final class Item_Ninjato extends SR_NinjaWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 14; }
	public function getItemWeight() { return 970; }
	public function getItemPrice() { return 1400; }
	public function getItemRange() { return 1.9; }
	public function getItemDescription() { return 'A short and slim Ninja Sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 14.5,
		);
	}
}
?>