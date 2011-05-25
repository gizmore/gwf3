<?php
final class Renraku_Security extends SR_NPC
{
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return 'Security'; }
	public function getNPCMeetPercent(SR_Party $party) { return 250.00; }
	public function canNPCMeet(SR_Party $party) { return Renraku::isAlert($party); }
	
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
			'firearms'  => rand(3, 4),
			'distance' => rand(10, 12),
			'sharpshooter' => rand(2, 3),
			'nuyen' => rand(40, 80),
			'base_hp' => rand(6, 9),
		);
	}
}
?>