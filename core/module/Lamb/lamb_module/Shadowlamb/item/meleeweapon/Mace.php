<?php
final class Item_Mace extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 1450; }
	public function getItemPrice() { return 775; }
	public function getItemDescription() { return 'An iron mace. You wonder why such weapons got popular within the past years.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5, 
			'min_dmg' => 1.0,
			'max_dmg' => 10.0,
		);
	}
	
}
?>