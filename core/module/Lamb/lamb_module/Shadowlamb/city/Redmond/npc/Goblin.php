<?php
final class Redmond_Goblin extends SR_NPC
{
	public function getNPCLevel() { return 5; }
	public function getNPCPlayerName() { return 'Goblin'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'gnome',
			'strength' => rand(0, 1),
			'quickness' => rand(2, 3),
			'base_hp' => rand(1, 4),
			'distance' => rand(1, 3),
			'nuyen' => rand(10, 40),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('Knife','BaseballBat'),
			'armor' => 'LeatherVest',
			'boots' => 'Sandals',
			'helmet' => 'Cap',
			'legs' => 'Shorts',
		);
	}
}
?>