<?php
final class Item_ShortSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 850; }
	public function getItemPrice() { return 575; }
	public function getItemDescription() { return 'A short steel sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8.0, 
			'min_dmg' => 2.0,
			'max_dmg' => 8.0,
		);
	}
	
}
?>