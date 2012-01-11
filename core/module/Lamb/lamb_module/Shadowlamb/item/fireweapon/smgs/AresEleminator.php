<?php
final class Item_AresEleminator extends SR_SMG
{
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 8; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 90; }
	public function getItemLevel() { return 24; }
	public function getItemWeight() { return 2250; }
	public function getItemPrice() { return 1400; }
	public function getItemDescription() { return 'A solid sniper rifle produced by Ares. It\'s illegal in most areas.'; }
	public function getItemRequirements() { return array('firearms'=>3,'smgs'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 20,
			'min_dmg' => 6,
			'max_dmg' => 16,
		);
	}
}
?>