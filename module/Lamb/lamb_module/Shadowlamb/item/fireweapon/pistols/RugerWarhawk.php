<?php
final class Item_RugerWarhawk extends SR_Pistol
{
	public function getAttackTime() { return 35; }
	public function getAmmoName() { return 'Ammo_11mm'; }
	public function getBulletsMax() { return 6; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 50; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 1550; }
	public function getItemPrice() { return 2750; }
	public function getItemDescription() { return 'A big pistol with fat 11mm bullets. Does big holes even for small heads.'; }
	public function getItemRequirements() { return array('firearms'=>3, 'pistols'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12.5,
			'min_dmg' => 5.5,
			'max_dmg' => 17.0,
		);
	}
}
?>