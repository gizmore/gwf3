<?php
final class Item_NinjaSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 15; }
	public function getItemWeight() { return 1030; }
	public function getItemPrice() { return 4096; }
	public function getItemDescription() { return 'A black, slim and deadly sword. Sweet.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8.5, 
			'min_dmg' => 5.5,
			'max_dmg' => 14.5,
		);
	}
}
?>