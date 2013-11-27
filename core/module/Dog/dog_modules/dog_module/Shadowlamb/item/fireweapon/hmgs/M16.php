<?php
final class Item_M16 extends SR_HMG
{
	public function getItemLevel() { return 25; }
	
	public function getAttackTime() { return 38; }
	public function getAmmoName() { return 'Ammo_5mm'; }
	public function getBulletsMax() { return 20; }
	public function getBulletsPerShot() { return 2; }
	public function getReloadTime() { return 50; }
	public function getItemWeight() { return 3260; }
	public function getItemPrice() { return 1400; }
	public function getItemDescription() { return 'The Momoshima16 is a remake from a MachineGun used in old wars, and reproduced by Momoshima Inc. since the fifties.'; }
	public function getItemRequirements() { return array('firearms'=>4,'hmgs'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 26,
			'min_dmg' => 3,
			'max_dmg' => 20,
		);
	}
}
?>