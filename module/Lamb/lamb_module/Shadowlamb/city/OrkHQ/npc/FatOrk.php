<?php
final class OrkHQ_FatOrk extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Fat Ork'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'strength' => rand(3, 4),
			'quickness' => rand(0, 1),
			'base_hp' => rand(4, 6),
			'distance' => rand(0, 4),
			'nuyen' => rand(0, 140),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ButchersKnife',
			'armor' => 'Clothes',
			'boots' => 'Sneakers',
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		return array('Bacon');
	}
}
?>