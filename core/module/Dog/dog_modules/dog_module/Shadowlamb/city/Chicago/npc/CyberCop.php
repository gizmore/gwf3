<?php
final class Chicago_CyberCop extends SR_NPC
{
	public function getNPCLevel() { return 15; }
	public function getNPCPlayerName() { return 'LargeDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'DroneArmor_of_marm:5,farm:5',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 6,
			'quickness' => 4,
			'distance' => 10,
			'firearms' => 5,
			'smgs' => 5,
			'sharpshooter' => 5,
			'nuyen' => 0,
			'base_hp' => rand(15, 20),
		);
	}
	
// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		if (rand(0,1))
// 		{
// 			return array('ElectricParts');
// 		}
// 		return array();
// 	}
}
?>