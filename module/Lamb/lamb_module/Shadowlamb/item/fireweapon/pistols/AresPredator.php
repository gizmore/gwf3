<?php
final class Item_AresPredator extends SR_Pistol
{
	public function getAttackTime() { return 35; }
	public function getAmmoName() { return 'Ammo_9mm'; }
	public function getBulletsMax() { return 8; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 60; }

	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 1250; }
	public function getItemPrice() { return 750; }
	public function getItemDescription() { return 'The famous "Ares Predator(tm)".'; }
	
	public function getItemRequirements() { return array('firearms'=>0); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 7,
			'min_dmg' => 4,
			'max_dmg' => 12,
		);
	}
	
}
?>