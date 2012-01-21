<?php
final class Renraku04_Militia extends SR_NPC
{
	public function getNPCLevel() { return 28; }
	public function getNPCPlayerName() { return 'Militia'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresEleminator',
			'armor' => 'LightBodyArmor',
			'helmet' => 'CombatHelmet',
			'legs' => 'KevlarLegs',
			'shield' => 'KevlarShield',
		);
	}
	public function getNPCInventory()
	{
		return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Stimpatch', 'NinjaSword', 'Flashbang');
	}
	
	public function getNPCCyberware()
	{
		return array('DermalPlates','WiredReflexes');
	}
	
	public function getNPCModifiers() {
		return array(
			'race' => 'halfelve',
			'gender' => 'male',
			'smgs' => rand(8, 12),
			'strength' => rand(7, 9),
			'quickness' => rand(10, 12),
			'firearms'  => rand(6, 12),
			'distance' => rand(20, 30),
			'sharpshooter' => rand(12, 20),
			'nuyen' => rand(30, 90),
			'base_hp' => rand(18, 32),
		);
	}
}
?>