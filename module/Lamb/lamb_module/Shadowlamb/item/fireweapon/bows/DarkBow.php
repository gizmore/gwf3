<?php
final class Item_DarkBow extends SR_Bow
{
	public function getAttackTime() { return 40; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getBulletsPerShot() { return 1; }
	public function getReloadTime() { return 5; }

	public function getItemLevel() { return 8; }
	public function getItemWeight() { return 800; }
	public function getItemPrice() { return 1250; }
	public function getItemDescription() { return 'A dark bow, made from the dark elves. It\'s a real weapon, nothing for kids.'; }
	
	public function getItemRequirements() { return array('bows' => 1, 'strength'=>3, 'firearms'=>1); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 7,
			'min_dmg' => 3,
			'max_dmg' => 7,
		);
	}
}
?>