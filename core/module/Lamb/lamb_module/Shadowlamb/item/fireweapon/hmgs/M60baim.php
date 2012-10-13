<?php
final class Item_M60baim extends SR_HMG
{
	public function getItemLevel() { return 38; }
	
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 50; }
	public function getBulletsPerShot() { return 2; }
	public function getReloadTime() { return 380; }
	public function getItemWeight() { return 7500; }
	public function getItemPrice() { return 9000; }
	public function getItemDropChance() { return 2.0; }
	public function getItemDescription() { return 'Compund improved version of the M60 HMG. The modifcations also half the mag.'; }
	public function getItemRequirements() { return array('firearms'=>4,'hmgs'=>2,'strength'=>4); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 35,
			'min_dmg' => 8,
			'max_dmg' => 32,
		);
	}
}
?>