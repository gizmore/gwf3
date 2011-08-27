<?php
final class Item_Axe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 60; }
	public function getItemLevel() { return 4; }
	public function getItemWeight() { return 1850; }
	public function getItemPrice() { return 95; }
	public function getItemRange() { return 1.8; }
	public function getItemDescription() { return 'A medium sized axe. looks good with a Skimask.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.0, 
			'min_dmg' => 2.0,
			'max_dmg' => 9.0,
		);
	}
}
?>