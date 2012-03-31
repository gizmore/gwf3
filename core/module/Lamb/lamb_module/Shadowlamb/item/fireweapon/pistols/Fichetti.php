<?php
final class Item_Fichetti extends SR_Pistol
{
	public function getAttackTime() { return 30; }
	public function getAmmoName() { return 'Ammo_5mm'; }
	public function getBulletsMax() { return 12; }
	public function getBulletsPerShot() { return 6; }
	public function getReloadTime() { return 50; }
	public function getItemLevel() { return 9; }
	public function getItemWeight() { return 1150; }
	public function getItemPrice() { return 450; }
	public function getItemDescription() { return 'Six 5.44mm at one shot. This is actually a small shotgun.'; }
	public function getItemRequirements() { return array('firearms'=>3,'pistols'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12,
			'min_dmg' => 6,
			'max_dmg' => 12,
		);
	}
}
?>