<?php
final class Item_RugerWarhawk extends SR_Pistol
{
	public function getAttackTime() { return 32; }
	public function getAmmoName() { return 'Ammo_11mm'; }
	public function getBulletsMax() { return 6; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 50; }
	public function getItemLevel() { return 11; }
	public function getItemWeight() { return 1450; }
	public function getItemPrice() { return 1350; }
	public function getItemDescription() { return 'A big pistol with 11mm bullets.'; }
	public function getItemRequirements() { return array('firearms'=>3,'pistols'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8,
			'min_dmg' => 6,
			'max_dmg' => 12,
		);
	}
}
?>