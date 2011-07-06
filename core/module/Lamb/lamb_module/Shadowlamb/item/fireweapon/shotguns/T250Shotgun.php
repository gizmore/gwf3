<?php
final class Item_T250Shotgun extends SR_Shotgun
{
	public function getAttackTime() { return 32; }
	public function getAmmoName() { return 'Ammo_Shotgun'; }
	public function getBulletsMax() { return 2; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 25; }
	public function getItemLevel() { return 13; }
	public function getItemWeight() { return 1450; }
	public function getItemPrice() { return 3750; }
	public function getItemDescription() { return 'A heavy shotgun. You could surely run amok in Element\'s school with it.'; }
	public function getItemRequirements() { return array('firearms'=>3,'strength'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 14,
			'min_dmg' => 2,
			'max_dmg' => 14,
		);
	}
}
?>