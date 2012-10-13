<?php
final class Vegas_Lazer extends SR_TalkingNPC
{
	public function getName() { return 'Lazer'; }
	public function getNPCLevel() { return 30; }
	public function getNPCPlayerName() { return 'Lazer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCQuests(SR_Player $player)
	{
		return array();
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M60',
			'armor' => 'AramitVest',
			'legs' => 'AramitLegs',
			'boots' => 'AramitBoots',
			'helmet' => 'AramitHelmet',
		);
	}
	public function getNPCInventory() { return array('1xStimpatch', '200xAmmo_7mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(10, 12),
			'quickness' => rand(14, 18),
			'distance' => rand(6, 8),
			'firearms' => rand(16, 20),
			'hmgs' => rand(16, 20),
			'sharpshooter' => rand(16, 20),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(80, 90),
		);
	}
}
?>