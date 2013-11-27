<?php
final class Item_Ninjaken extends SR_NinjaWeapon
{
	public function getAttackTime() { return 42; }
	public function getItemLevel() { return 22; }
	public function getItemWeight() { return 995; }
	public function getItemPrice() { return 1550; }
	public function getItemRange() { return 2.2; }
	public function getItemDescription() { return 'A sharp Ninja Sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 16.5, 
			'min_dmg' => 4.5,
			'max_dmg' => 16.5,
		);
	}
}
?>