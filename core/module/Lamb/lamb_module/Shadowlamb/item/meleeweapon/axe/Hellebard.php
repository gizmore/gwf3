<?php
final class Item_Hellebard extends SR_MeleeWeapon
{
	public function getAttackTime() { return 75; }
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 2750; }
	public function getItemPrice() { return 275; }
	public function getItemRange() { return 4.2; }
	public function getItemDescription() { return 'An ancient hellebard. Fun for medieval melee battles.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.0, 
			'min_dmg' => 3.0,
			'max_dmg' => 14.0,
		);
	}
}
?>