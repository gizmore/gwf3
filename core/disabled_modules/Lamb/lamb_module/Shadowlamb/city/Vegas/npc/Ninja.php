<?php
final class Vegas_Ninja extends SR_NPC
{
	public function getNPCLevel() { return 31; }
	public function getNPCPlayerName() { return 'Ninja'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => array('halfelve', 'darkelve'),
			'gender' => 'male',
			'strength' => rand(7, 9),
			'melee' => rand(8, 12),
			'sharpshooter' => rand(8, 12),
			'ninja' => rand(8, 12),
			'quickness' => rand(8, 12),
			'base_hp' => rand(25, 40),
			'distance' => rand(8, 12),
			'nuyen' => rand(20, 70),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('NinjaSword', 'Ninjato', 'Ninjaken'),
			'armor' => array('NinjaCloak'),
			'legs' => array('Hakama'),
			'boots' => array('ChikaTabi'),
			'belt' => array('UwaObi'),
			'gloves' => array('Yugake'),
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
