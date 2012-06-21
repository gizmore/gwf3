<?php
final class Item_SirenePike extends SR_MeleeWeapon
{
	public function getAttackTime() { return 42; }
	public function getItemLevel() { return 29; }
	public function getItemWeight() { return 1750; }
	public function getItemPrice() { return 1175; }
	public function getItemRange() { return 4.5; }
	public function getItemDropChance() { return 30.0; }
	public function getItemDescription() { return 'A long pike worn by the sirenes. It´s really sharp and you fear their deadly tip.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 14.5, 
			'min_dmg' => 5.5,
			'max_dmg' => 21.5,
		);
	}
}
?>
