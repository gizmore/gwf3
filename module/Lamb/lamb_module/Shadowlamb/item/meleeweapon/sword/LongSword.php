<?php
final class Item_LongSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 7; }
	public function getItemWeight() { return 1250; }
	public function getItemPrice() { return 1075; }
	public function getItemDescription() { return 'A long steel sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 7.5, 
			'min_dmg' => 2.5,
			'max_dmg' => 8.5,
		);
	}
}
?>