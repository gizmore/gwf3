<?php
final class Item_KnightsSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 39; }
	public function getItemLevel() { return 20; }
	public function getItemWeight() { return 1950; }
	public function getItemPrice() { return 1275; }
	public function getItemRange() { return 3.5; }
	public function getItemDescription() { return 'A long knights sword, as used in the holy wars.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 9.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 14.5,
		);
	}
}
?>