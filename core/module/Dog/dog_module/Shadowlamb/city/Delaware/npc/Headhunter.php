<?php
final class Delaware_Headhunter extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'Headhunter'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'T250Shotgun',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'shield' => 'KevlarShield',
			'helmet' => 'KevlarHelmet',
		);
	}

	public function getNPCInventory() { return array('Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Knife'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'gender' => 'male',
			'melee' => '3',
			'strength' => rand(2, 3),
			'quickness' => rand(6, 7),
			'distance' => rand(8, 12),
			'shotguns' => rand(6, 8),
			'firearms' => rand(5, 8),
			'sharpshooter' => rand(6, 7),
			'nuyen' => rand(40, 80),
			'base_hp' => rand(14, 18),
		);
	}

	public function getNPCLoot(SR_Player $player)
	{
		SR_Quest::getQuest($player, 'Troll_Support')->onKillHeadHunter($player);
		return array();
	}
}
?>