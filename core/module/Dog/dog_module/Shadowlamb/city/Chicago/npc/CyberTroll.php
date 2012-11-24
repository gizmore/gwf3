<?php
final class Chicago_CyberTroll extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'Troll'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'KevlarVest',
			'helmet' => 'KevlarHelmet',
			'boots' => 'ArmyBoots',
			'legs' => 'KevlarLegs',
			'weapon' => 'HK227sVariant',
			'shield' => 'KevlarShield',
		);
	}
	
	public function getNPCCyberware()
	{
		return array(
			'DermalPlates',
			'Cybermuscles',
			'WiredReflexes',
		);
	}
	
	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'melee' => rand(3, 4),
			'ninja' => rand(2, 3),
			'strength' => rand(8, 10),
			'quickness' => rand(5, 8),
			'distance' => rand(16, 20),
			'smgs' => rand(7, 10),
			'firearms' => rand(7, 10),
			'sharpshooter' => rand(7, 10),
			'nuyen' => rand(50, 110),
			'base_hp' => rand(30, 40),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Chicago_ShrineMonksRevenge');
		if ($quest->isInQuest($player))
		{
			$quest->onKilled($player, 3);
		}
		return array();
	}
}
?>