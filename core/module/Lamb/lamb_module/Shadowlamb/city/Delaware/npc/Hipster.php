<?php
final class Delaware_Hipster extends SR_NPC
{
	public function getNPCLevel() { return 15; }
	public function getNPCPlayerName() { return 'Hipster'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'halfelve',
			'strength' => rand(2, 3),
			'melee' => rand(4, 7),
			'ninja' => rand(4, 5),
			'sharpshooter' => rand(3, 4),
			'quickness' => rand(4, 5),
			'base_hp' => rand(12, 15),
			'distance' => rand(2, 4),
			'nuyen' => rand(25, 65),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'earring' => array('LO_Earring_of_strength:1'),
			'weapon' => array('SteelNunchaku'),
			'armor' => array('LeatherVest','StuddedVest'),
			'boots' => array('Boots','ArmyBoots'),
			'helmet' => array('Cap', 'LeatherCap'),
			'legs' => array('Trousers','Shorts'),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		SR_Quest::getQuest($player, 'Delaware_MCGuest12')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCGuest22')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCJohnson1')->onKillHipster($player);
		return array();
	}
}
?>