<?php
final class Seattle_Killer extends SR_NPC
{
	public function getNPCLevel() { return 11; }
	public function getNPCPlayerName() { return 'Killer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhhawk',
			'armor' => 'ChainVest',
			'legs' => 'ChainLegs',
			'boots' => 'ChainBoots',
			'shield' => 'SmallShield',
		);
	}

	public function getNPCInventory() { return array('Ammo_11mm', 'Ammo_11mm', 'Knife'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(3, 4),
			'quickness' => rand(7, 8),
			'distance' => rand(8, 12),
			'pistols' => rand(6, 8),
			'firearms' => rand(4, 6),
			'sharpshooter' => rand(5, 8),
			'nuyen' => rand(200, 300),
			'base_hp' => rand(18, 22),
		);
	}
}
?>