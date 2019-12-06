<?php
final class Item_AresViper extends SR_Pistol
{
	public function getAttackTime() { return 18; }
	public function getAmmoName() { return 'Ammo_5mm'; }
	public function getBulletsMax() { return 36; }
	public function getBulletsPerShot() { return 3; }
	public function getReloadTime() { return 45; }
	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 1050; }
	public function getItemPrice() { return 675; }
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
