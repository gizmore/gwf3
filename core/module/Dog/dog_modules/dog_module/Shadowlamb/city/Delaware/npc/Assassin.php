<?php
final class Delaware_Assassin extends SR_NPC
{
	public function getNPCLevel() { return 18; }
	public function getNPCPlayerName() { return 'Assassin'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => rand('human', 'vampire', 'woodelve', 'darkelve', 'ork')
			'strength' => rand(4, 5),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(3, 5),
			'quickness' => rand(5, 8),
			'ninja' => rand(3, 4),
			'base_hp' => rand(16, 20),
			'distance' => rand(2, 4),
			'nuyen' => rand(25, 50),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => rand('NinjaSword', 'WoodenNunchaku', 'Knife', 'Fists'),
			'armor' => 'KevlarVest',
			'boots' => 'Sneakers',
			'helmet' => 'LeatherCap',
			'legs' => 'ElvenShorts',
		);
	}
}
