<?php
final class Chicago_Samurai extends SR_NPC
{
	public function getNPCLevel() { return 22; }
	public function getNPCPlayerName() { return 'Samurai'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Katana',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'SamuraiMask',
			'amulet' => 'LO_Amulet_of_attack:10',
		);
	}

	public function getNPCInventory() { return array('Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfork',
			'gender' => 'male',
			'melee' => '7',
			'strength' => rand(6, 8),
			'quickness' => rand(2, 5),
			'distance' => rand(2, 4),
			'sharpshooter' => rand(3, 5),
			'nuyen' => rand(20, 60),
			'base_hp' => rand(22, 28),
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