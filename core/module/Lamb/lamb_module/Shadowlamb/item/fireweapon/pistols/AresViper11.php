<?php
final class Item_AresViper11 extends SR_Pistol
{
	public function getAttackTime() { return 40; }
	public function getAmmoName() { return 'Ammo_11mm'; }
	public function getBulletsMax() { return 8; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 75; }
	public function getItemLevel() { return 13; }
	public function getItemWeight() { return 1950; }
	public function getItemPrice() { return 750; }
	public function getItemDescription() { return 'A russian modification of the Ares Viper. It is illegal.'; }
	public function getItemRequirements() { return array('firearms'=>2,'pistols'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 10,
			'min_dmg' => 5,
			'max_dmg' => 15,
		);
	}
}
?>