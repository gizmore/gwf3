<?php
final class Item_FairyStaff extends SR_MeleeWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemRange() { return 50; }
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 275; }
	public function getItemDescription() { return 'A light brown staff made from the woodelves. It requires arcane powers to use it properly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 6.0, 
			'min_dmg' => 0.0,
			'max_dmg' => 2.0,
			'max_mp' => 5.0,
			'intelligence' => 1.8,
		);
	}
}
?>