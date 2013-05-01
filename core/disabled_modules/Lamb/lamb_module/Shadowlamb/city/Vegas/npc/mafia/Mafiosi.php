<?php
class Vegas_Mafiosi extends SR_NPC
{
	public function getName() { return 'Mafiosi'; }
	public function getNPCLevel() { return 29; }
	public function getNPCPlayerName() { return 'Mafiosi'; }
	public function getNPCMeetPercent(SR_Party $party) { return 25.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Magnum',
			'armor' => 'AramitVest',
			'legs' => 'AramitLegs',
			'boots' => 'AramitBoots',
		);
	}
	public function getNPCInventory() { return array('1xStimpatch', '100xAmmo_11mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(10, 12),
			'quickness' => rand(12, 14),
			'distance' => rand(6, 8),
			'firearms' => rand(15, 18),
			'pistols' => rand(16, 20),
			'sharpshooter' => rand(14, 16),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(40, 60),
		);
	}
}
?>
