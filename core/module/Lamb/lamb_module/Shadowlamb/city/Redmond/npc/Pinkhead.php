<?php
final class Redmond_Pinkhead extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Pinkhead'; }
	public function getNPCMeetPercent(SR_Party $party) { return 90.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
//	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'Clothes',
		);
	}
	public function getNPCInventory() { return array('LargeBeer'); }
	public function getNPCModifiers()
	{
		return array(
			'nuyen' => rand(5, 30),
			'base_hp' => rand(-7, -5),
			'distance' => rand(0, 4),
			'strength' => rand(0, 1),
			'quickness' => rand(0, 1),
			'melee' => rand(0, 1),
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => -0.1,
			'max_dmg' => -0.9,
			'attack' => -0.3,
		);
	}
}
?>