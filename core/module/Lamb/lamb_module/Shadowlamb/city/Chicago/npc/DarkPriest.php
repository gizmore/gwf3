<?php
final class Chicago_DarkPriest extends SR_NPC
{
	public function getNPCLevel() { return 21; }
	public function getNPCPlayerName() { return 'DarkPriest'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ArchStaff',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'ArmyHelmet',
			'shield' => 'KevlarShield',
		);
	}

	public function getNPCInventory() { return array('FirstAid'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'elve',
			'gender' => 'male',
			'magic' => '5',
			'melee' => '4',
			'strength' => rand(2, 4),
			'quickness' => rand(3, 5),
			'distance' => rand(8, 14),
			'hmgs' => rand(4, 5),
			'firearms' => rand(4, 5),
			'sharpshooter' => rand(3, 5),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(14, 20),
			'base_mp' => rand(20, 30),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'firebolt' => 3,
			'freeze' => 3,
		);
	}
	
// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		SR_Quest::getQuest($player, 'Troll_Forever')->onKillCommando($player);
// 		return array();
// 	}
	
//	
//	public function getNPCLoot(SR_Player $player)
//	{
//		$quest = SR_Quest::getQuest($player, 'Seattle_GJohnson1');
//		if ($quest->isInQuest($player))
//		{
//			$quest->increase('sr4qu_amount', 1);
//			$player->message(sprintf('Now you killed %d Killers for Mr.Johnson.', $quest->getAmount()));
//		}
//		return array();
//	}
}
?>