<?php
final class Item_Challenger extends SR_HMG
{
	public function getItemLevel() { return 32; }
	
	public function getAttackTime() { return 42; }
	public function getAmmoName() { return 'Ammo_9mm'; }
	public function getBulletsMax() { return 30; }
	public function getBulletsPerShot() { return 2; }
	public function getReloadTime() { return 120; }
	public function getItemWeight() { return 3920; }
	public function getItemPrice() { return 1600; }
	public function getItemDescription() { return 'The challenger was the first heavy machine gun blasting 9mm bullets above triple as fast as the speed of sound.'; }
	public function getItemRequirements() { return array('firearms'=>4,'hmgs'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 27,
			'min_dmg' => 4,
			'max_dmg' => 25,
		);
	}
}
?>