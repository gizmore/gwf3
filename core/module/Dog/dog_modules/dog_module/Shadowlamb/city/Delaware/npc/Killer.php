<?php
final class Delaware_Killer extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'Killer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhawk',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'KevlarBoots',
			'shield' => 'SmallShield',
		);
	}

	public function getNPCInventory() { return array('Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Knife'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(1, 3),
			'quickness' => rand(2, 4),
			'distance' => rand(8, 12),
			'pistols' => rand(2, 4),
			'firearms' => rand(3, 5),
			'sharpshooter' => rand(2, 3),
			'nuyen' => rand(40, 80),
			'base_hp' => rand(14, 18),
		);
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