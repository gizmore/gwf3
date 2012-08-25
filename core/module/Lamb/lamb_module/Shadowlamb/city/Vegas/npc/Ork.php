<?php
final class Vegas_Ork extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'Ork'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'gender' => 'male',
			'strength' => rand(4, 8),
			'melee' => rand(5, 10),
			'sharpshooter' => rand(4, 8),
			'firearms' => rand(4, 8),
			'shotguns' => rand(4, 8),
			'quickness' => rand(4, 10),
			'base_hp' => rand(35, 60),
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