<?php
final class Item_DaneAxe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 2250; }
	public function getItemPrice() { return 225; }
	public function getItemRange() { return 2.6; }
	public function getItemDescription() { return 'A single sided Viking Axe. It\'s ancient design is still deadly in this century.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 16.5,
		);
	}
}
?>