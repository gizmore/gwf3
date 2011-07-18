<?php
final class Delaware_Emo extends SR_NPC
{
	public function getNPCLevel() { return 15; }
	public function getNPCPlayerName() { return 'Emo'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	
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
			'magic' => rand(2, 3),
			'base_mp' => rand(5, 10),
		);
	}
	
	public function getNPCSpells()
	{
		return array('calm'=>2);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'earring' => array('LO_Ring_of_strength:1'),
			'weapon' => array('Fists'),
			'armor' => array('LeatherVest','StuddedVest'),
			'boots' => array('Boots','ArmyBoots'),
			'helmet' => array('Cap', 'LeatherCap'),
			'legs' => array('Trousers','Shorts'),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		SR_Quest::getQuest($player, 'Delaware_MCGuest11')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCGuest32')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCJohnson1')->onKillEmo($player);
		return array();
	}
}
?>