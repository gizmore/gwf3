<?php
final class Vegas_Troll extends SR_NPC
{
	public function getNPCLevel() { return 26; }
	public function getNPCPlayerName() { return 'Troll'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'strength' => rand(5, 10),
			'melee' => rand(5, 10),
			'sharpshooter' => rand(5, 10),
			'firearms' => rand(5, 10),
			'shotguns' => rand(5, 10),
			'quickness' => rand(5, 10),
			'base_hp' => rand(50, 80),
			'distance' => rand(2, 10),
			'nuyen' => rand(80, 140),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('T250Shotgun', 'Jackhammer'),
			'armor' => 'KevlarVest',
			'legs' => array('StuddedLegs', 'KevlarLegs'),
			'boots' => array('Boots', 'ArmyBoots'),
			'belt' => array('LeatherBelt'),
		);
	}
	
	public function getNPCInventory()
	{
		return array(
			'Knife',
			'2xStimpatch',
			'50xAmmo_Shotgun',
		);
	}

// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		return array();
// 	}
	
}
?>