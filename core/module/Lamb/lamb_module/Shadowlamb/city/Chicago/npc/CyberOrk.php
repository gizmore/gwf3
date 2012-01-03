<?php
final class Chicago_CyberOrk extends SR_NPC
{
	public function getNPCLevel() { return 24; }
	public function getNPCPlayerName() { return 'Ork'; }
	public function getNPCMeetPercent(SR_Party $party) { return 70.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'KevlarVest',
			'helmet' => 'LeatherCap',
			'boots' => 'LeatherBoots',
			'legs' => 'KevlarLegs',
			'weapon' => 'T250Shotgun',
			'shield' => 'ElvenShield',
		);
	}
	
	public function getNPCInventory() { return array('Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Stimpatch'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'gender' => 'male',
			'melee' => rand(3, 4),
			'ninja' => rand(2, 3),
			'strength' => rand(6, 9),
			'quickness' => rand(5, 7),
			'distance' => rand(14, 18),
			'shotguns' => rand(6, 9),
			'firearms' => rand(6, 9),
			'sharpshooter' => rand(6, 9),
			'nuyen' => rand(50, 90),
			'base_hp' => rand(28, 36),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Chicago_ShrineMonksRevenge');
		if ($quest->isInQuest($player))
		{
			$quest->onKilled($player, 2);
		}
		return array();
	}
}
?>