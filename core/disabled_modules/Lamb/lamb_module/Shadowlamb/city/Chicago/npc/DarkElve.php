<?php
final class Chicago_DarkElve extends SR_NPC
{
	public function getNPCLevel() { return 27; }
	public function getNPCPlayerName() { return 'DarkElve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 45.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ReignBow',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ElvenBoots',
			'helmet' => 'CombatHelmet',
			'shield' => 'ElvenShield',
			'amulet' => 'Amulet_of_defense:1',
		);
	}
	
	public function getNPCCyberware()
	{
		return array(
			'WiredReflexesV2',
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'firebolt' => 4,
		);
	}

	public function getNPCInventory() { return array('Ammo_Arrow', 'Ammo_Arrow', 'Ammo_Arrow', 'Ammo_Arrow', 'NinjaSword', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'gender' => 'male',
			'melee' => '4',
			'magic' => rand(4, 6),
			'quickness' => rand(6, 8),
			'distance' => rand(6, 14),
			'smgs' => rand(7, 11),
			'intelligence' => rand(6, 8),
			'firearms' => rand(8, 12),
			'bows' => rand(8, 12),
			'sharpshooter' => rand(8, 12),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(24, 38),
			'base_mp' => rand(10, 25),
		);
	}
}
?>