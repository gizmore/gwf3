<?php
final class Chicago_Ninja extends SR_NPC
{
	public function getNPCLevel() { return 23; }
	public function getNPCPlayerName() { return 'Ninja'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('NinjaSword', 'Ninjaken', 'Ninjato'),
			'armor' => 'Uwagi',
			'legs' => 'Hakama',
			'boots' => 'ChikaTabi',
			'amulet' => 'LO_Amulet_of_attack:15',
		);
	}

	public function getNPCInventory() { return array('Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfelve',
			'gender' => 'male',
			'melee' => '4',
			'ninja' => '6',
			'strength' => rand(6, 8),
			'quickness' => rand(5, 7),
			'distance' => rand(2, 4),
			'sharpshooter' => rand(4, 7),
			'nuyen' => rand(32, 34),
			'base_hp' => rand(20, 32),
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