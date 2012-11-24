<?php
final class OrkHQ_HalfTroll extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'HQTroll'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('BaseballBat', 'IronPipe', 'Club', 'Knife'),
			'armor' => 'LeatherVest',
			'legs' => 'Trousers',
			'boots' => array('Sneakers','Sandals'),
		);
	}
	public function getNPCModifiers() {
		return array(
			'race' => 'halftroll',
			'nuyen' => rand(40, 120),
			'base_hp' => rand(12, 14),
			'strength' => rand(4, 5),
			'quickness' => rand(2, 3),
			'melee' => rand(4, 5),
			'distance' => rand(0, 2),
		);
	}
}
?>