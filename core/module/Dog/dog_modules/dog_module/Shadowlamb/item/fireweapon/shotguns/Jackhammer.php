<?php
final class Item_Jackhammer extends SR_Shotgun
{
	public function getAttackTime() { return 35; }
	public function getAmmoName() { return 'Ammo_Shotgun'; }
	public function getBulletsMax() { return 10; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 40; }
	public function getItemLevel() { return 26; }
	public function getItemWeight() { return 4570; }
	public function getItemPrice() { return 1400; }
	public function getItemDescription() { return 'Rare orignal designed by John Anderson of Pancor Industries in New Mexico. Quite good firepower with a bit sloppy design.'; }
	public function getItemRequirements() { return array('firearms'=>2,'strength'=>3,'shotguns'=>0); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 24,
			'min_dmg' => 5,
			'max_dmg' => 20,
		);
	}
}
?>
