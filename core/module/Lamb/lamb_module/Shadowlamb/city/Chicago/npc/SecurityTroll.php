<?php
final class Chicago_SecurityTroll extends SR_NPC
{
	public function getNPCLevel() { return 21; }
	public function getNPCPlayerName() { return 'SecurityTroll'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'LeatherCap',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'melee' => rand(3, 6),
			'strength' => rand(5, 7),
			'quickness' => rand(4, 7),
			'distance' => rand(8, 18),
			'smgs' => rand(3, 6),
			'firearms' => rand(3, 6),
			'sharpshooter' => rand(3, 7),
			'nuyen' => rand(30, 120),
			'base_hp' => rand(20, 30),
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