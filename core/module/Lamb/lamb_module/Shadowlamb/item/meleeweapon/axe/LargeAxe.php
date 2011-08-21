<?php
final class Item_LargeAxe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 65; }
	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 2250; }
	public function getItemPrice() { return 115; }
	public function getItemRange() { return 1.8; }
	public function getItemDescription() { return 'A large axe. Cuts trees too. Has not been tested on motor blocks yet..'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 6.0, 
			'min_dmg' => 3.0,
			'max_dmg' => 11.0,
		);
	}
}
?>