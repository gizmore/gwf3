<?php
final class Item_William911 extends SR_Pistol
{
	public function getAttackTime() { return 35; }
	public function getAmmoName() { return 'Ammo_9mm'; }
	public function getBulletsMax() { return 7; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 55; }
	public function getItemLevel() { return 9; }
	public function getItemWeight() { return 1250; }
	public function getItemPrice() { return 750; }
	public function getItemDescription() { return 'A solid and accurate 9mm pistol. A bit pricey and not famous.'; }
	public function getItemRequirements() { return array('firearms'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 10,
			'min_dmg' => 4,
			'max_dmg' => 14.5,
		);
	}
}
?>