<?php
final class Renraku04_Security extends SR_NPC
{
	public function getNPCLevel() { return 24; }
	public function getNPCPlayerName() { return 'Security'; }
	public function getNPCMeetPercent(SR_Party $party) { return 350.00; }
	public function canNPCMeet(SR_Party $party) { return $this->getNPCCityClass()->isAlert($party); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'William911S',
			'armor' => 'KevlarVest',
			'helmet' => 'Cap',
			'legs' => 'KevlarLegs',
		);
	}
	
	public function getNPCInventory()
	{
		return array('Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Stimpatch', 'Knife', 'Flashbang');
	}

	public function getNPCCyberware()
	{
		return array('DermalPlates','WiredReflexes');
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'pistols' => rand(6, 9),
			'strength' => rand(4, 5),
			'quickness' => rand(7, 10),
			'firearms'  => rand(6, 9),
			'distance' => rand(20, 30),
			'sharpshooter' => rand(12, 20),
			'nuyen' => rand(30, 90),
			'base_hp' => rand(24, 36),
		);
	}
}
?>