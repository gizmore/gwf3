<?php
final class Seattle_Shaolin extends SR_NPC
{
	public function getNPCLevel() { return 12; }
	public function getNPCPlayerName() { return 'Shaolin'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'SteelNunchaku',
			'armor' => 'FineRobe',
			'legs' => 'FineLegs',
			'boots' => 'LeatherBoots',
		);
	}
	public function getNPCInventory() { return array('SmallFirstAid'); }
	public function getNPCSpells() { return array('heal'=>0); }
	public function getNPCModifiers() {
		return array(
			'race' => SR_Player::getRandomRace(),
			'gender' => SR_Player::getRandomGender(),
			'strength' => rand(1, 5),
			'quickness' => rand(1, 4),
			'distance' => rand(2, 8),
			'melee' => rand(2, 4),
			'ninja' => rand(2, 4),
			'sharpshooter' => rand(1, 3),
			'nuyen' => rand(30, 70),
			'base_hp' => rand(3, 12),
			'magic' => rand(1, 2),
			'intelligence' => 4,
			'wisdom' => 2,
			'base_mp' => rand(0, 2),
		);
		
	}
}
?>
