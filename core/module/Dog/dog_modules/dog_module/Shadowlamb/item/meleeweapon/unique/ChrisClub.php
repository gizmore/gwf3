<?php
final class Item_ChrisClub extends SR_MeleeWeapon
{
	public function isItemRare() { return true; }
	public function getAttackTime() { return 34; }
	public function getItemDropChance() { return 5.5; }
	public function getItemLevel() { return 1; }
	public function getItemWeight() { return 1050; }
	public function getItemPrice() { return 125; }
	public function getItemRange() { return 1.3; }
	public function getItemDescription() { return 'This club is a leftover of bjoern new years festival. Rare!.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12.5,
			'min_dmg' => 1.5,
			'max_dmg' => 8.5,
			'melee' => 2.0,
		);
	}
}
?>
