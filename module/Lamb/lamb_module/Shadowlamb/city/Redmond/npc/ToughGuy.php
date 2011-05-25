<?php
final class Redmond_ToughGuy extends SR_NPC
{
	public function getNPCLevel() { return 3; }
	public function getNPCPlayerName() { return 'Tough Guy'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('BaseballBat', 'IronPipe'),
			'armor' => 'Clothes',
			'legs' => 'Trousers',
			'boots' => array('Sneakers', 'Sandals'),
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => rand(30, 40),
			'base_hp' => rand(-2, 0),
			'distance' => rand(0, 2),
		);
	}
	
}
?>