<?php
final class Item_BrassKnuckles extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 350; }
	public function getItemRange() { return 1.0; }
	public function getItemPrice() { return 140; }
	public function getItemDescription() { return 'Steel brass knuckles. Much better than bare fists.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5,
			'min_dmg' => 0.0,
			'max_dmg' => 5.5,
		);
	}
}
?>
