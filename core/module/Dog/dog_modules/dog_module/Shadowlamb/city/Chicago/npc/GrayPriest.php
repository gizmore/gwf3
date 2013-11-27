<?php
final class Chicago_GrayPriest extends SR_NPC
{
	public function getNPCLevel() { return 24; }
	public function getNPCPlayerName() { return 'GrayPriest'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ArchStaff',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'ArmyHelmet',
			'shield' => 'KevlarShield',
		);
	}

	public function getNPCInventory() { return array('FirstAid'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'elve',
			'gender' => 'male',
			'magic' => '6',
			'melee' => '4',
			'strength' => rand(2, 4),
			'quickness' => rand(5, 7),
			'distance' => rand(8, 14),
			'melee' => rand(4, 5),
			'sharpshooter' => rand(3, 5),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(14, 20),
			'base_mp' => rand(30, 40),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'firebolt' => 3,
			'blow' => 3,
		);
	}
}
?>