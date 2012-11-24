<?php
final class Delaware_Knight extends SR_NPC
{
	public function getNPCLevel() { return 18; }
	public function getNPCPlayerName() { return 'Knight'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'strength' => rand(4, 5),
			'melee' => rand(5, 7),
			'sharpshooter' => rand(1, 2),
			'quickness' => rand(3, 4),
			'base_hp' => rand(12, 16),
			'distance' => rand(1, 3),
			'nuyen' => rand(20, 40),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('KnightsSword'),
			'armor' => 'KnightsArmor',
			'boots' => 'KnightsBoots',
			'helmet' => 'KnightsHelmet',
			'legs' => 'KnightsLegs',
		);
	}
}
?>