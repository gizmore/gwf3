<?php
final class Chicago_GiantTroll extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'GiantTroll'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'KevlarVest',
			'helmet' => 'KevlarHelmet',
			'boots' => 'ArmyBoots',
			'legs' => 'KevlarLegs',
			'weapon' => array('SpikedClub', 'ArabianAxe'),
			'shield' => 'KevlarShield',
		);
	}
	
	public function getNPCCyberware()
	{
		return array(
			'DermalPlates',
			'Cybermuscles',
			'WiredReflexesV2',
		);
	}
	
	public function getNPCInventory() { return array('Stimpatch', 'Pizza'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'melee' => rand(8, 10),
			'ninja' => rand(2, 3),
			'strength' => rand(9, 11),
			'quickness' => rand(5, 8),
			'distance' => rand(4, 6),
			'sharpshooter' => rand(9, 11),
			'nuyen' => rand(40, 90),
			'base_hp' => rand(35, 45),
		);
	}
	
// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		$quest = SR_Quest::getQuest($player, 'Chicago_ShrineMonksRevenge');
// 		if ($quest->isInQuest($player))
// 		{
// 			$quest->onKilled($player, 3);
// 		}
// 		return array();
// 	}
}
?>