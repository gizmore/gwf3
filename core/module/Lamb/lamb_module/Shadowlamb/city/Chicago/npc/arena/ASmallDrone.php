<?php
final class Chicago_ASmallDrone extends SR_NPC
{
	public function getNPCLevel() { return 19; }
	public function getNPCPlayerName() { return 'SmallDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
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
			'strength' => 1,
			'quickness' => 1,
			'distance' => 10,
			'firearms' => 4,
			'smgs' => 4,
			'sharpshooter' => 4,
			'nuyen' => 0,
			'base_hp' => 30,
		);
	}
}
?>