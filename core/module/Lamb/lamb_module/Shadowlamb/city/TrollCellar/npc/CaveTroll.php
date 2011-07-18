<?php
final class TrollCellar_CaveTroll extends SR_NPC
{
	public function getNPCLevel() { return 19; }
	public function getNPCPlayerName() { return 'CaveTroll'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'strength' => rand(3, 4),
			'melee' => rand(5, 6),
			'sharpshooter' => rand(3, 4),
			'quickness' => rand(3, 4),
			'base_hp' => rand(22, 24),
			'distance' => rand(1, 3),
			'nuyen' => rand(25, 70),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('SamuraiSword'),
			'armor' => 'StuddedVest',
			'legs' => 'Trousers',
			'boots' => 'Boots',
		);
	}

	public function getNPCLoot(SR_Player $player)
	{
		if (!rand(0, 4))
		{
			return array('Emerald');
		}
		return array();
	}
	
}
?>