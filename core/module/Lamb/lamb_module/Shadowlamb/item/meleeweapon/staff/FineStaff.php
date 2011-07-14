<?php
final class Item_FineStaff extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 24; }
	public function getItemWeight() { return 750; }
	public function getItemPrice() { return 875; }
	public function getItemDropChance() { return 1.00; }
	public function getItemDescription() { return 'A fine staff with magic force. Quite expensive.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 7.5, 
			'min_dmg' => 1.0,
			'max_dmg' => 9.0,
			'max_mp' => 9.0,
			'intelligence' => 2.5,
			'wisdom' => 2.5,
		);
	}
	
}
?>