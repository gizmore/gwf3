<?php
final class Item_William911S extends SR_Pistol
{
	public function getAttackTime() { return 34; }
	public function getAmmoName() { return 'Ammo_11mm'; }
	public function getBulletsMax() { return 5; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 57; }
	public function getItemLevel() { return 16; }
	public function getItemWeight() { return 1450; }
	public function getItemPrice() { return 1250; }
	public function getItemDescription() { return 'A solid and accurate 11mm pistol. A bit pricey and not famous.'; }
	public function getItemRequirements() { return array('firearms'=>3,'pistols'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12,
			'min_dmg' => 5,
			'max_dmg' => 17.5,
		);
	}
}
?>