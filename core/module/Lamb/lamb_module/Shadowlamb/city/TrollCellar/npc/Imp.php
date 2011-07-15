<?php
final class TrollCellar_Imp extends SR_NPC
{
	public function getNPCLevel() { return 18; }
	public function getNPCPlayerName() { return 'Imp'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfork',
			'strength' => rand(3, 4),
			'melee' => rand(5, 6),
			'sharpshooter' => rand(3, 4),
			'quickness' => rand(3, 5),
			'base_hp' => rand(18, 21),
			'distance' => rand(1, 3),
			'nuyen' => rand(15, 50),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('SamuraiSword'),
			'armor' => 'StuddedVest',
			'legs' => 'Trousers',
		);
	}
	
}
?>