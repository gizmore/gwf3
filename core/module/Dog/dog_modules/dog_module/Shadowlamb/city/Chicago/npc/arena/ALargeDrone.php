<?php
final class Chicago_ALargeDrone extends SR_NPC
{
	public function getNPCLevel() { return 21; }
	public function getNPCPlayerName() { return 'LargeDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 30.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'DroneArmor_of_marm:8,farm:8',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 2,
			'quickness' => 5,
			'distance' => 30,
			'firearms' => 8,
			'smgs' => 8,
			'sharpshooter' => 8,
			'nuyen' => 0,
			'base_hp' => 50,
		);
	}
}
?>