<?php
final class Prison_Guard extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Guard'; }
	public function isNPCDropping(SR_Party $party) { return false; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		$this->getNPCCityClass()->isAlert($party) ? 300 : 0;
	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'William911S',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'CopBoots',
			'helmet' => 'KevlarHelmet',
			'shield' => 'KevlarShield',
		);
	}
	public function getNPCInventory() { return array('Stimpatch','Ammo_11mm','Ammo_11mm','Ammo_11mm','Ammo_11mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 12),
			'melee' => rand(1, 2),
			'firearms' => rand(3, 4),
			'pistols' => rand(4, 4),
			'sharpshooter' => rand(5, 6),
			'nuyen' => rand(10, 20),
			'base_hp' => rand(15, 25),
		);
	}
}
?>