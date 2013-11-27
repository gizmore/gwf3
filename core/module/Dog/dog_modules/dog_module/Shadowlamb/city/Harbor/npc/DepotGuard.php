<?php
final class Harbor_DepotGuard extends SR_NPC
{
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return 'Guard'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresLightFire',
			'armor' => 'KevlarVest',
			'legs' => 'Trousers',
			'helmet' => 'Cap',
			'boots' => 'Boots',
		);
	}
	
	public function getNPCInventory() { return array('Knife','Ammo_7mm','Ammo_7mm','Ammo_7mm','Ammo_7mm'); }
	
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(1, 2),
			'melee' => rand(1, 2),
			'pistols' => rand(1, 2),
			'firearms' => rand(2, 3),
			'quickness' => rand(1, 3),
			'distance' => rand(6, 10),
			'nuyen' => rand(20, 50),
			'base_hp' => rand(7, 11),
		);
	}
}
?>