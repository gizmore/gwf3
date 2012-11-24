<?php
final class Delaware_Ork extends SR_NPC
{
	public function getNPCLevel() { return 16; }
	public function getNPCPlayerName() { return 'Ork'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'strength' => rand(3, 4),
			'melee' => rand(4, 6),
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
			'weapon' => array('LongSword','BroadSword'),
			'armor' => 'LeatherVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
		);
	}
}
?>