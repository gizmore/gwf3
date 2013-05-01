<?php
final class Chicago_Cobra extends SR_NPC
{
	public function getNPCLevel() { return 22; }
	public function getNPCPlayerName() { return 'CobraCommando'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M16',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
			'shield' => 'KevlarShield',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfork',
			'gender' => 'male',
			'melee' => '5',
			'strength' => rand(4, 6),
			'quickness' => rand(4, 5),
			'distance' => rand(12, 16),
			'hmgs' => rand(5, 6),
			'firearms' => rand(5, 6),
			'sharpshooter' => rand(4, 6),
			'nuyen' => rand(60, 100),
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