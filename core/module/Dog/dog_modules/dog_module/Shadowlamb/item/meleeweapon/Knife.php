<?php
final class Item_Knife extends SR_MeleeWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemLevel() { return 1; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 150; }
	public function getItemRange() { return 1.4; }
	public function getItemDescription() { return 'A long steel knife.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5,
			'min_dmg' => 2.5,
			'max_dmg' => 6.0,
		);
	}
}
?>
