<?php
final class Item_AresViper extends SR_Pistol
{
	public function getAttackTime() { return 30; }
	public function getAmmoName() { return 'Ammo_9mm'; }
	public function getBulletsMax() { return 8; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 55; }
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 1350; }
	public function getItemPrice() { return 650; }
	public function getItemDescription() { return 'The famous "Ares Viper(tm)" pistol.'; }
	public function getItemRequirements() { return array('firearms'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 13.5,
			'min_dmg' => 4,
			'max_dmg' => 14,
		);
	}
}
?>