<?php
final class Vegas_Skinner extends SR_TalkingNPC
{
	public function getName() { return 'Skinner'; }
	public function getNPCLevel() { return 31; }
	public function getNPCPlayerName() { return 'Skinner'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCQuests(SR_Player $player)
	{
		return array();
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'BarrettM82LF',
			'armor' => 'AramitVest',
			'legs' => 'AramitLegs',
			'boots' => 'AramitBoots',
			'helmet' => 'AramitHelmet',
		);
	}
	public function getNPCInventory() { return array('1xStimpatch', '150xAmmo_12mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(10, 12),
			'quickness' => rand(14, 18),
			'distance' => rand(6, 8),
			'firearms' => rand(16, 20),
			'smgs' => rand(16, 20),
			'sharpshooter' => rand(16, 20),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(50, 60),
		);
	}
}
?>