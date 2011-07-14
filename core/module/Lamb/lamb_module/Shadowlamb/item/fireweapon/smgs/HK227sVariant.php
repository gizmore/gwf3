<?php
final class Item_HK227sVariant extends SR_SMG
{
	public function getAttackTime() { return 32; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 30; }
	public function getBulletsPerShot() { return 3; }
	public function getReloadTime() { return 60; }
	public function getItemLevel() { return 14; }
	public function getItemWeight() { return 1550; }
	public function getItemPrice() { return 1100; }
	public function getItemDescription() { return 'A small SubMachineGun from Hekler&Koch. A sure thing for combat.'; }
	public function getItemRequirements() { return array('firearms'=>3,'smgs'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 18,
			'min_dmg' => 3,
			'max_dmg' => 16,
		);
	}
}
?>