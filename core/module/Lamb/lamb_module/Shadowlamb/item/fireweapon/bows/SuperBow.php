<?php
final class Item_SuperBow extends SR_Bow
{
	public function getAttackTime() { return 38; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getReloadTime() { return 8; }
	public function getItemLevel() { return 22; }
	public function getItemWeight() { return 970; }
	public function getItemPrice() { return 1150; }
	public function getItemDescription() { return 'A bow produced from Nadji Sports GmbH in germany. A quite solid and deadly hunting device.'; }
	
	public function getItemRequirements() { return array('bows' => 1, 'strength'=>3); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 14,
			'min_dmg' => 2.5,
			'max_dmg' => 13,
		);
	}
}
?>