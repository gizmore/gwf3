<?php
final class TrollHQ2_TrollChief extends SR_TalkingNPC
{
	public function getNPCPlayerName() { return 'Larry'; }
	public function getNPCLevel() { return 16; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'strength' => rand(8, 12),
			'quickness' => rand(1, 2),
			'melee' => rand(6, 9),
			'base_hp' => rand(40, 48),
			'distance' => rand(4, 8),
			'nuyen' => rand(100, 200),
		);
	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'NinjaSword',
			'armor' => 'KevlarVest',
			'boots' => 'KevlarBoots',
			'helmet' => 'SamuraiMask',
		);
	}
//	public function getNPCLoot(SR_Player $player)
//	{
//		$quest = SR_Quest::getQuest($player, 'Redmond_Orks');
//		if ($quest->isInQuest($player)) {
//			return array('Reginalds_Bracelett');
//		}
//		return array();
//	}
}
?>
