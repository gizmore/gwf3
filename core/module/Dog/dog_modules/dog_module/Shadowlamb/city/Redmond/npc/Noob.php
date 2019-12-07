<?php
final class Redmond_Noob extends SR_NPC
{
	public function getNPCLevel() { return (1) }
	public function getNPCPlayerName() { return 'Noob'; }
	public function getNPCMeetPercent(SR_Party $party) { return 70.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
//	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'Clothes',
			'legs' => 'Shorts',
			'helmet' => 'TinfoilCap',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers()
	{
		return array(
			'race' => rand('human', 'dwarf', 'elve', 'ork')
			'gender' => rand('male', 'female')
			'nuyen' => rand(10, 25),
			'base_hp' => rand(-6, -4),
			'distance' => rand(0, 2),
			'strength' => rand(1, 3)
			'quickness' => rand(1, 3)
			'ninja' => rand(0, 1)
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => -0.1,
			'max_dmg' => -0.3,
			'attack' => -0.1,
		);
	}
}
