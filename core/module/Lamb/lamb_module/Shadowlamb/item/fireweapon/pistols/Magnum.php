<?php
final class Item_Magnum extends SR_Pistol
{
	public function getAttackTime() { return 36; }
	public function getAmmoName() { return 'Ammo_11mm'; }
	public function getBulletsMax() { return 6; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 50; }
	public function getItemLevel() { return 21; }
	public function getItemWeight() { return 1650; }
	public function getItemPrice() { return 1050; }
	public function getItemDescription() { return 'A remake of the famous Magnum.44. 11mm bullets who can punch a hole in a motorblock.'; }
	public function getItemRequirements() { return array('firearms'=>3, 'pistols'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 14.5,
			'min_dmg' => 6.5,
			'max_dmg' => 19.0,
		);
	}
}
?>