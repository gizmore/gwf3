<?php
final class Chicago_AMediumDrone extends SR_NPC
{
	public function getNPCLevel() { return 20; }
	public function getNPCPlayerName() { return 'MediumDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'DroneArmor_of_marm:6,farm:6',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 2,
			'quickness' => 4,
			'distance' => 20,
			'firearms' => 6,
			'smgs' => 6,
			'sharpshooter' => 6,
			'nuyen' => 0,
			'base_hp' => 40,
		);
	}
}
?>