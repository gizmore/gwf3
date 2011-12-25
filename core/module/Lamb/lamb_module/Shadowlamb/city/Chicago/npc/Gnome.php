<?php
final class Chicago_Gnome extends SR_NPC
{
	public function getNPCLevel() { return 20; }
	public function getNPCPlayerName() { return 'Gnome'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'ArmyHelmet',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Knife', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'gnome',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 14),
			'smgs' => rand(3, 5),
			'firearms' => rand(3, 5),
			'sharpshooter' => rand(3, 5),
			'nuyen' => rand(50, 90),
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