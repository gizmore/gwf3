<?php
final class Chicago_CyberGoblin extends SR_NPC
{
	public function getNPCLevel() { return 23; }
	public function getNPCPlayerName() { return 'Goblin'; }
	public function getNPCMeetPercent(SR_Party $party) { return 80.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'KevlarVest',
			'helmet' => 'LeatherCap',
			'boots' => 'LeatherBoots',
			'legs' => 'StuddedLegs',
			'weapon' => 'RugerWarhawk',
			'shield' => 'SmallShield',
		);
	}
	
	public function getNPCInventory() { return array('Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfork',
			'gender' => 'male',
			'melee' => rand(3, 4),
			'ninja' => rand(2, 3),
			'strength' => rand(6, 8),
			'quickness' => rand(6, 8),
			'distance' => rand(12, 16),
			'pistols' => rand(5, 8),
			'firearms' => rand(5, 8),
			'sharpshooter' => rand(5, 8),
			'nuyen' => rand(40, 80),
			'base_hp' => rand(24, 34),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Chicago_ShrineMonksRevenge');
		if ($quest->isInQuest($player))
		{
			$quest->onKilled($player, 1);
		}
		return array();
	}
	
}
?>