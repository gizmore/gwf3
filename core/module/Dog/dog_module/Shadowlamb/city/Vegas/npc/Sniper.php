<?php
final class Vegas_Sniper extends SR_NPC
{
	public function getNPCLevel() { return 29; }
	public function getNPCPlayerName() { return 'Sniper'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'gender' => 'male',
			'strength' => rand(3, 6),
			'melee' => rand(4, 7),
			'sharpshooter' => rand(8, 12),
			'firearms' => rand(8, 12),
			'quickness' => rand(6, 8),
			'base_hp' => rand(29, 49),
			'distance' => rand(14, 24),
			'nuyen' => rand(40, 150),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('BarrettM82LF'),
			'armor' => 'KevlarVest',
			'legs' => array('KevlarLegs'),
			'boots' => array('ArmyBoots'),
			'belt' => array('LeatherBelt'),
		);
	}
	
	public function getNPCInventory()
	{
		return array(
			'Knife',
			'2xStimpatch',
			'120xAmmo_12mm',
		);
	}

// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		return array();
// 	}
	
}
?>