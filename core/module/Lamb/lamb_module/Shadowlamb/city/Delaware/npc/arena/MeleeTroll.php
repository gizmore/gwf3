<?php
final class Delaware_MeleeTroll extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'MeleeTroll'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 10.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
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
			'weapon' => array('Katana'),
			'armor' => 'StuddedVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
			'legs' => 'StuddedLegs',
		);
	}
}
?>