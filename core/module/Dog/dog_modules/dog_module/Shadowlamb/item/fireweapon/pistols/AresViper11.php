<?php
final class Item_AresViper11 extends SR_Pistol
{
	public function getAttackTime() { return 35; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 36; }
	public function getBulletsPerShot() { return 3; }
	public function getReloadTime() { return 55; }
	public function getItemLevel() { return 13; }
	public function getItemWeight() { return 1050; }
	public function getItemPrice() { return 950; }
	public function getItemDescription() { return 'A russian modification of the Ares Viper. It is illegal.'; }
	public function getItemRequirements() { return array('firearms'=>2,'pistols'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 15,
			'min_dmg' => 5,
			'max_dmg' => 15,
		);
	}
}
?>
