<?php
final class Seattle_Samurai extends SR_NPC
{
	public function getNPCLevel() { return 9; }
	public function getNPCPlayerName() { return 'Samurai'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'SamuraiSword',
			'armor' => 'LeatherVest',
			'legs' => 'Trousers',
			'boots' => 'LeatherBoots',
			'helmet' => 'SamuraiMask',
		);
	}
	public function getNPCInventory() { return array('SmallFirstAid'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 4),
			'quickness' => rand(3, 5),
			'distance' => rand(0, 2),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(1, 3),
			'nuyen' => rand(60, 120),
			'base_hp' => rand(14, 20),
		);
	}
}
?>
