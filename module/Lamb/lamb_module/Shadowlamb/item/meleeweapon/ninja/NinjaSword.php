<?php
final class Item_NinjaSword extends SR_NinjaWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 13; }
	public function getItemWeight() { return 1030; }
	public function getItemPrice() { return 4096; }
	public function getItemDescription() { return 'A black, slim and deadly sword. Sweet.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 11.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 13.5,
		);
	}
}
?>