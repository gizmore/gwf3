<?php
final class Delaware_Commando extends SR_NPC
{
	public function getNPCLevel() { return 19; }
	public function getNPCPlayerName() { return 'Commando'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'HK227sVariant',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'helmet' => 'CombatHelmet',
//			'shield' => 'SmallShield',
		);
	}

	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Knife'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(1, 3),
			'quickness' => rand(2, 4),
			'distance' => rand(8, 12),
			'smgs' => rand(2, 4),
			'firearms' => rand(3, 5),
			'sharpshooter' => rand(2, 3),
			'nuyen' => rand(40, 80),
			'base_hp' => rand(14, 18),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		SR_Quest::getQuest($player, 'Troll_Forever')->onKillCommando($player);
		return array();
	}
	
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