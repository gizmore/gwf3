<?php
final class Seattle_Robber extends SR_NPC
{
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return 'Robber'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresLightFire',
			'armor' => 'ChainVest',
			'legs' => 'Trousers',
			'boots' => 'LeatherBoots',
		);
	}

	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(2, 3),
			'distance' => rand(8, 10),
			'pistols' => rand(1, 2),
			'firearms' => rand(1, 3),
			'sharpshooter' => rand(1, 2),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(2, 6),
		);
	}
}
?>