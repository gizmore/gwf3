<?php
final class Chicago_DarkMessiah extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'DarkMessiah'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
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
			'magic' => '5',
			'melee' => '4',
			'intelligence' => '5',
			'strength' => rand(2, 4),
			'quickness' => rand(3, 5),
			'distance' => rand(8, 14),
			'hmgs' => rand(4, 5),
			'firearms' => rand(4, 5),
			'sharpshooter' => rand(3, 5),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(14, 20),
			'base_mp' => rand(20, 30),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'fireball' => 4,
		);
	}
}
?>