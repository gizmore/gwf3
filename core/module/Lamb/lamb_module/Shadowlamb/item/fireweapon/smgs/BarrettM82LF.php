<?php
final class Item_BarrettM82LF extends SR_SMG
{
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_12mm'; }
	public function getBulletsMax() { return 10; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 75; }
	public function getItemLevel() { return 32; }
	public function getItemWeight() { return 7600; }
	public function getItemPrice() { return 1900; }
	public function getItemDescription() { return 'Lighter version of Barett M28 and still excellent for sharpshooters.'; }
	public function getItemRequirements() { return array('firearms'=>3,'smgs'=>3,'sharpshooter'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 28,
			'min_dmg' => 3,
			'max_dmg' => 26,
			'sharpshooter' => 2,
		);
	}
}
?>