<?php
final class Delaware_DarkKnight extends SR_NPC
{
	public function getNPCLevel() { return 18; }
	public function getNPCPlayerName() { return 'DarkKnight'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'strength' => rand(4, 5),
			'melee' => rand(5, 7),
			'sharpshooter' => rand(4, 5),
			'quickness' => rand(4, 5),
			'base_hp' => rand(20, 22),
			'distance' => rand(1, 3),
			'nuyen' => rand(30, 50),
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
			'shield' => 'KnightsShield',
			'amulet' => 'LO_Amulet_of_strength:2,quickness:2',
		);
	}
}
?>