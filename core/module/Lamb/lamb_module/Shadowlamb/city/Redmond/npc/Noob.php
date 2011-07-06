<?php
final class Redmond_Noob extends SR_NPC
{
	public function getNPCLevel() { return 1; }
	public function getNPCPlayerName() { return 'Noob'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
//	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'legs' => 'Shorts',
			'helmet' => 'TinfoilCap',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers()
	{
		return array(
			'nuyen' => rand(10, 25),
			'base_hp' => rand(-4, -3),
			'distance' => rand(0, 2),
			'strength' => 1,
			'quickness' => 1,
			'melee' => 1,
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => -0.1,
			'max_dmg' => -0.8,
			'attack' => -0.2,
		);
	}
}
?>