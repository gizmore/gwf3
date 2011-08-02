<?php
final class Item_SteelBow extends SR_Bow
{
	public function getAttackTime() { return 55; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 1450; }
	public function getItemPrice() { return 120; }
	public function getItemDescription() { return 'A simple bow of steel. Needs quite some strength and skill to use it.'; }
	
	public function getItemRequirements() { return array('strength'=>2, 'bows'=>1); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5,
			'min_dmg' => 2,
			'max_dmg' => 7,
		);
	}
}
?>