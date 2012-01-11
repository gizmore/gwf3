<?php
final class Chicago_EliteSniper extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'Sniper'; }
	public function getNPCMeetPercent(SR_Party $party) { return 12.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresEleminator',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
		);
	}

	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(3, 4),
			'quickness' => rand(4, 5),
			'distance' => rand(20, 40),
			'hmgs' => rand(8, 12),
			'firearms' => rand(8, 12),
			'sharpshooter' => rand(8, 12),
			'nuyen' => rand(80, 120),
			'base_hp' => rand(18, 24),
		);
	}
}
?>