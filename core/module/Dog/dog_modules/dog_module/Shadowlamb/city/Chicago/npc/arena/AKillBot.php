<?php
final class Chicago_AKillBot extends SR_NPC
{
	public function getNPCLevel() { return 22; }
	public function getNPCPlayerName() { return 'KillBot'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M16',
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
			'quickness' => 8,
			'distance' => 35,
			'firearms' => 10,
			'hmgs' => 10,
			'sharpshooter' => 12,
			'nuyen' => 0,
			'base_hp' => 60,
		);
	}
}
?>