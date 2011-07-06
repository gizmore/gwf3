<?php
final class Item_ElvenStaff extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 550; }
	public function getItemPrice() { return 1275; }
	public function getItemDescription() { return 'A wooden staff for magicians, charmed by the elves.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.0, 
			'min_dmg' => 1.5,
			'max_dmg' => 6.0,
			'max_mp' => 3.0,
			'intelligence' => 1.5,
		);
	}
	
}
?>