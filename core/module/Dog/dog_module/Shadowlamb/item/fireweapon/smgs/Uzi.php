<?php
final class Item_Uzi extends SR_SMG
{
	public function getAttackTime() { return 28; }
	public function getAmmoName() { return 'Ammo_5mm'; }
	public function getBulletsMax() { return 60; }
	public function getBulletsPerShot() { return 4; }
	public function getReloadTime() { return 70; }
	public function getItemLevel() { return 16; }
	public function getItemWeight() { return 1750; }
	public function getItemPrice() { return 1000; }
	public function getItemDescription() { return 'A light submachine gun. Good price for good firepower.'; }
	public function getItemRequirements() { return array('firearms'=>4,'smgs'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 20,
			'min_dmg' => 1,
			'max_dmg' => 15,
		);
	}
}
?>