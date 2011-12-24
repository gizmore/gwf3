<?php
final class Chicago_SecurityDrone extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'Drone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'DroneArmor_of_marm:4,farm:4',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 5,
			'quickness' => 2,
			'distance' => 12,
			'firearms' => 4,
			'smgs' => 3,
			'sharpshooter' => 4,
			'nuyen' => 0,
			'base_hp' => rand(14, 18),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		if (rand(0,1))
		{
			return array('ElectricParts');
		}
		return array();
	}
}
?>