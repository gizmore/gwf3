<?php
final class Item_Microgun extends SR_HMG
{
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_4mm'; }
	public function getBulletsMax() { return 30; }
	public function getBulletsPerShot() { return 2; }
	public function getReloadTime() { return 150; }
	public function getItemLevel() { return 36; }
	public function getItemWeight() { return 2790; }
	public function getItemPrice() { return 1900; }
	public function getItemDescription() { return 'The Microgun shoots special 4mm ammonition with a high fire rate.'; }
	public function getItemRequirements() { return array('firearms'=>4,'hmgs'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 28,
			'min_dmg' => 2,
			'max_dmg' => 30,
		);
	}
}
?>