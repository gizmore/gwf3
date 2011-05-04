<?php
final class Item_AresLightFire extends SR_Pistol
{
	public function getAttackTime() { return 30; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 6; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 55; }

	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 1150; }
	public function getItemPrice() { return 650; }
	public function getItemDescription() { return 'The cheapest pistol on the market. Not much damage but reliable.'; }
	
	public function getItemRequirements() { return array('firearms'=>0); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5,
			'min_dmg' => 4,
			'max_dmg' => 8,
		);
	}
	
}
?>