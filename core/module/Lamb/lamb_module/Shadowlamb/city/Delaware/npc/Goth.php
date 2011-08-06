<?php
final class Delaware_Goth extends SR_NPC
{
	public function getNPCLevel() { return 15; }
	public function getNPCPlayerName() { return 'Goth'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'strength' => rand(2, 3),
			'melee' => rand(3, 5),
			'ninja' => rand(4, 5),
			'sharpshooter' => rand(3, 4),
			'quickness' => rand(4, 5),
			'base_hp' => rand(14, 16),
			'distance' => rand(4, 6),
			'nuyen' => rand(15, 65),
			'magic' => rand(2, 3),
			'base_mp' => rand(5, 10),
		);
	}
	
	public function getNPCSpells()
	{
		return array('firebolt'=>1);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'amulet' => array('LO_Amulet_of_strength:1'),
			'weapon' => array('SteelNunchaku'),
			'armor' => array('LeatherVest','StuddedVest'),
			'boots' => array('Boots','ArmyBoots'),
			'helmet' => array('Cap', 'LeatherCap'),
			'legs' => array('Trousers','Shorts'),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		SR_Quest::getQuest($player, 'Delaware_MCGuest21')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCGuest31')->onKill($player);
		SR_Quest::getQuest($player, 'Delaware_MCJohnson1')->onKillGoth($player);
		return array();
	}
}
?>