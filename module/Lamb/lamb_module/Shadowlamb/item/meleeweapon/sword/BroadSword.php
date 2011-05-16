<?php
final class Item_BroadSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 950; }
	public function getItemPrice() { return 725; }
	public function getItemDescription() { return 'A broad steel sword.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5, 
			'min_dmg' => 2.5,
			'max_dmg' => 8.5,
		);
	}
	
}
?>