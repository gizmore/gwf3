<?php
final class Seattle_Headhunter extends SR_NPC
{
	public function getNPCLevel() { return 14; }
	public function getNPCPlayerName() { return 'Headhunter'; }
	public function getNPCMeetPercent(SR_Party $party) { return 10.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('RugerWarhawk', 'Knife', 'Fists')
			'armor' => rand('KevlarVest', 'ChainVest')
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'KevlarHelmet',
		);
	}
	public function getNPCInventory() { return array('Knife', 'RugerWarhawk','Stimpatch','Ammo_11mm','Ammo_11mm','Ammo_11mm','Ammo_11mm','Ammo_11mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => rand('male', 'female')
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 12),
			'melee' => rand(2, 4),
			'firearms' => rand(3, 4),
			'pistols' => rand(3, 4),
			'sharpshooter' => rand(1, 3),
			'nuyen' => rand(30, 70),
			'base_hp' => rand(4, 9),
		);
	}
}
