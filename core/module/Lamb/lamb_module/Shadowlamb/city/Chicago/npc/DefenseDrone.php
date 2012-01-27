<?php
final class Chicago_DefenseDrone extends SR_NPC
{
	public function getNPCLevel() { return 22; }
	public function getNPCPlayerName() { return 'DefenseDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 25.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Microgun',
			'armor' => 'DroneArmor_of_marm:4,farm:7',
		);
	}

	public function getNPCInventory() { return array('Ammo_4mm', 'Ammo_4mm', 'Ammo_4mm', 'Ammo_4mm', 'Ammo_4mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 6,
			'quickness' => 5,
			'distance' => 16,
			'firearms' => 8,
			'hmgs' => 6,
			'sharpshooter' => 6,
			'nuyen' => 0,
			'base_hp' => rand(18, 22),
		);
	}
	
// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		if (rand(0,1))
// 		{
// 			return array('MilitaryCircuits');
// 		}
// 		return array();
// 	}
}
?>