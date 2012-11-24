<?php
final class Chicago_CombatDrone extends SR_NPC
{
	public function getNPCLevel() { return 20; }
	public function getNPCPlayerName() { return 'CombatDrone'; }
	public function getNPCMeetPercent(SR_Party $party) { return 30.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'HK227sVariant',
			'armor' => 'DroneArmor_of_marm:6,farm:6',
		);
	}

	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'droid',
			'gender' => 'male',
			'strength' => 6,
			'quickness' => 5,
			'distance' => 16,
			'firearms' => 8,
			'smgs' => 6,
			'sharpshooter' => 6,
			'nuyen' => 0,
			'base_hp' => rand(18, 22),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		if (rand(0,1))
		{
			return array('MilitaryCircuits');
		}
		return array();
	}
}
?>