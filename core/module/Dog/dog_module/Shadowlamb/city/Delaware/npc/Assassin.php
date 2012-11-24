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
			'race' => 'human',
			'strength' => rand(3, 4),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(1, 2),
			'quickness' => rand(2, 4),
			'ninja' => rand(3, 4),
			'base_hp' => rand(18, 20),
			'distance' => rand(2, 4),
			'nuyen' => rand(25, 50),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('NinjaSword','Katana'),
			'armor' => 'StuddedVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'LeatherCap',
			'legs' => 'StuddedLegs',
		);
	}
}
?>