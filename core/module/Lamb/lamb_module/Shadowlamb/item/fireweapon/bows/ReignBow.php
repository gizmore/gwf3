<?php
final class Item_ReignBow extends SR_Bow
{
	public function getAttackTime() { return 42; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getReloadTime() { return 7; }
	public function getItemLevel() { return 20; }
	public function getItemWeight() { return 835; }
	public function getItemPrice() { return 950; }
	public function getItemDescription() { return 'A special dark bow, made from the dark elves in the race wars.'; }
	
	public function getItemRequirements() { return array('bows' => 1, 'strength'=>3); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 10,
			'min_dmg' => 3.5,
			'max_dmg' => 12,
		);
	}
}
?>