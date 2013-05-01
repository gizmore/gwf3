<?php
final class Chicago_Sniper extends SR_NPC
{
	public function getNPCLevel() { return 23; }
	public function getNPCPlayerName() { return 'Sniper'; }
	public function getNPCMeetPercent(SR_Party $party) { return 16.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M16',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(3, 4),
			'quickness' => rand(4, 5),
			'distance' => rand(20, 40),
			'hmgs' => rand(8, 12),
			'firearms' => rand(8, 12),
			'sharpshooter' => rand(8, 12),
			'nuyen' => rand(80, 120),
			'base_hp' => rand(18, 24),
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