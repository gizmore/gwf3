<?php
final class Item_QWand extends SR_MeleeWeapon
{
	public function getAttackTime() { return 25; }
	public function getItemLevel() { return 6; }
	public function getItemDropChance() { return 2.56; }
	public function getItemWeight() { return 150; }
	public function getItemPrice() { return 3275; }
	public function getItemDescription() { return 'A small magic wand. It glows in different colors.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4.0, 
			'min_dmg' => 0.5,
			'max_dmg' => 8.0,
			'max_mp' => 8.0,
			'intelligence' => 2.5,
			'wisdom' => 3.5,
		);
	}
	
	public function getItemRequirements()
	{
		return array(
			'level' => 12,
		);
	}
}
?>