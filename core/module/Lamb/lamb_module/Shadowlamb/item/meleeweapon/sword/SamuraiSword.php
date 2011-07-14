<?php
final class Item_SamuraiSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 9; }
	public function getItemWeight() { return 1150; }
	public function getItemPrice() { return 1075; }
	public function getItemDescription() { return 'A nicely ornamented samurai sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 10.0, 
			'min_dmg' => 4.5,
			'max_dmg' => 11.0,
		);
	}
}
?>