<?php
final class Redmond_Burglar extends SR_NPC
{
	public function getNPCLevel() { return 2; }
	public function getNPCPlayerName() { return 'Burglar'; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('Club'),
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => rand(10, 30),
			'base_hp' => rand(-4, -2),
			'strength' => 2,
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => 0,
			'max_dmg' => 0,
		);
	}
	
}
?>