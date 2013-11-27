<?php
final class DeathValley_Scorpion extends SR_NPC
{
	public function getNPCLevel() { return 34; }
	public function getNPCPlayerName() { return 'GiantScorpion'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'animal',
			'gender' => 'male',
			'strength' => rand(6, 8),
			'melee' => rand(12, 14),
			'ninja' => rand(8, 10),
			'sharpshooter' => rand(10, 14),
			'quickness' => rand(8, 10),
			'base_hp' => rand(39, 59),
			'distance' => rand(4, 12),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('ScorpionSting', 'ScorpionClaws'),
			'armor' => 'ScorpionPlate',
			'legs' => array('ScorpionLegs'),
		);
	}
	
	public function getNPCInventory()
	{
		return array(
		);
	}

// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		return array();
// 	}
	
}
?>