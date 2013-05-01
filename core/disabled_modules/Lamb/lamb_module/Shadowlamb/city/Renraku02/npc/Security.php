<?php
final class Renraku02_Security extends SR_NPC
{
	public function getNPCLevel() { return 10; }
	public function getNPCPlayerName() { return 'Security'; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresViper',
			'armor' => 'KevlarVest',
			'helmet' => 'Cap',
			'legs' => 'KevlarLegs',
		);
	}
	public function getNPCInventory() { return array('Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Stimpatch'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'pistols' => rand(3, 4),
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'firearms'  => rand(4, 5),
			'distance' => rand(10, 12),
			'sharpshooter' => rand(2, 3),
			'nuyen' => rand(20, 60),
			'base_hp' => rand(7, 11),
		);
	}
}
?>