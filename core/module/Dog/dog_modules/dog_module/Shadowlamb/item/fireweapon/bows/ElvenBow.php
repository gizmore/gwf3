<?php
final class Item_ElvenBow extends SR_Bow
{
	public function getAttackTime() { return 45; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 850; }
	public function getItemPrice() { return 450; }
	public function getItemDescription() { return 'A nice bow mode from elves. The elves really enjoy archery.'; }
	public function getItemRequirements() { return array('bows'=>0); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5,
			'min_dmg' => 2,
			'max_dmg' => 6,
		);
	}
}
?>