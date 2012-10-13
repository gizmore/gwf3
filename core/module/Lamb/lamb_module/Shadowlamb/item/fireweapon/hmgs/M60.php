<?php
final class Item_M60 extends SR_HMG
{
	public function getItemLevel() { return 38; }
	
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_7mm'; }
	public function getBulletsMax() { return 100; }
	public function getBulletsPerShot() { return 2; }
	public function getReloadTime() { return 400; }
	public function getItemWeight() { return 10500; }
	public function getItemPrice() { return 8500; }
	public function getItemDropChance() { return 5.0; }
	public function getItemDescription() { return 'The M60 Heavy Machine gun. A gun like noother.'; }
	public function getItemRequirements() { return array('firearms'=>4,'hmgs'=>2,'strength'=>6); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 34,
			'min_dmg' => 8,
			'max_dmg' => 32,
		);
	}
}
?>