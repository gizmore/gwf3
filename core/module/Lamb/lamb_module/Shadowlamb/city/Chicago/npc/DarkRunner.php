<?php
final class Chicago_DarkRunner extends SR_NPC
{
	public function getNPCLevel() { return 27; }
	public function getNPCPlayerName() { return 'Runner'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresEleminator',
			'armor' => 'LightBodyArmor',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
			'shield' => 'KevlarShield',
		);
	}
	
	public function getNPCCyberware()
	{
		return array(
			'WiredReflexesV2',
		);
	}

	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'NinjaSword', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(4, 5),
			'quickness' => rand(6, 8),
			'distance' => rand(6, 14),
			'smgs' => rand(7, 11),
			'intelligence' => rand(6, 8),
			'firearms' => rand(8, 12),
			'sharpshooter' => rand(8, 12),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(28, 42),
		);
	}
}
?>