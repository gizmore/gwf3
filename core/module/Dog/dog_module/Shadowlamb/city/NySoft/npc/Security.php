<?php
final class NySoft_Security extends SR_NPC
{
	public function getNPCLevel() { return 20; }
	public function getNPCPlayerName() { return 'Security'; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'KevlarVest',
			'helmet' => 'CopCap',
			'boots' => 'LeatherBoots',
			'legs' => 'StuddedLegs',
			'weapon' => 'RugerWarhawk',
// 			'shield' => 'SmallShield',
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
	
// 	public function getNPCLoot(SR_Player $player)
// 	{
// 		$quest = SR_Quest::getQuest($player, 'Chicago_ShrineMonksRevenge');
// 		if ($quest->isInQuest($player))
// 		{
// 			$quest->onKilled($player, 1);
// 		}
// 		return array();
// 	}
	
}
?>