<?php
final class Chicago_Army extends SR_NPC
{
	public function getNPCLevel() { return 24; }
	public function getNPCPlayerName() { return 'Soldier'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M16',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'ArmyHelmet',
			'shield' => 'KevlarShield',
		);
	}
	
	public function getNPCCyberware()
	{
		return array(
			'CybermusclesV2',
			'DermalPlatesV2',
			'WiredReflexesV2',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(4, 5),
			'quickness' => rand(6, 8),
			'distance' => rand(8, 14),
			'hmgs' => rand(5, 7),
			'firearms' => rand(6, 8),
			'sharpshooter' => rand(5, 8),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(22, 36),
		);
	}
}
?>