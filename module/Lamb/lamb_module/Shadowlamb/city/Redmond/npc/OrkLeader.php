<?php
final class Redmond_OrkLeader extends SR_NPC
{
	public function getNPCPlayerName() { return 'OrkLeader'; }
	public function getNPCLevel() { return 9; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'strength' => rand(5, 6),
			'quickness' => rand(1, 2),
			'base_hp' => rand(10, 14),
			'distance' => rand(2, 4),
			'nuyen' => rand(100, 200),
		);
	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Knife',
			'armor' => 'LeatherVest',
			'boots' => 'LeatherBoots',
			'helmet' => 'BikerHelmet',
		);
	}
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Redmond_Orks');
		if ($quest->isInQuest($player)) {
			return array('Reginalds_Bracelett');
		}
		return array();
	}
}
?>
