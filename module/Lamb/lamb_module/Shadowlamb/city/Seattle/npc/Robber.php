<?php
final class Seattle_Robber extends SR_NPC
{
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return 'Robber'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhhawk',
			'armor' => 'ChainVest',
			'legs' => 'Trousers',
			'boots' => 'LeatherBoots',
		);
	}

	public function getNPCInventory() { return array('Ammo_Arrow', 'Ammo_Arrow'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(3, 4),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 10),
			'pistols' => rand(2, 3),
			'firearms' => rand(2, 3),
			'sharpshooter' => rand(1, 3),
			'nuyen' => rand(80, 170),
			'base_hp' => rand(10, 18),
		);
	}
}
?>