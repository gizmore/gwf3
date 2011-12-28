<?php
final class Prison_Ward extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Ward'; }
	public function isNPCDropping(SR_Party $party) { return false; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		$this->getNPCCityClass()->isAlert($party) ? 300 : 0;
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'William911',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'CopBoots',
		);
	}
	
	public function getNPCInventory() { return array('Stimpatch','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm'); }
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
			'base_hp' => rand(10, 20),
		);
	}
}
?>