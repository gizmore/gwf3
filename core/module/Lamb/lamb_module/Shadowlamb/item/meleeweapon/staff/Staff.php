<?php
final class Item_Staff extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 4; }
	public function getItemWeight() { return 650; }
	public function getItemPrice() { return 175; }
	public function getItemDescription() { return 'A wooden staff for magicians.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4.0, 
			'min_dmg' => 1.0,
			'max_dmg' => 5.0,
			'max_mp' => 2.0,
			'intelligence' => 0.5,
		);
	}
	
}
?>