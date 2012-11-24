<?php
final class Chicago_Yakuza extends SR_NPC
{
	public function getNPCLevel() { return 22; }
	public function getNPCPlayerName() { return 'Yakuza'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ElvenBoots_of_quickness:3',
			'helmet' => 'ElvenCap_of_quickness:2',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfelve',
			'gender' => 'male',
			'melee' => rand(3, 4),
			'strength' => rand(5, 7),
			'quickness' => rand(5, 7),
			'distance' => rand(10, 18),
			'smgs' => rand(4, 5),
			'firearms' => rand(4, 5),
			'sharpshooter' => rand(5, 7),
			'nuyen' => rand(30, 90),
			'base_hp' => rand(16, 27),
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