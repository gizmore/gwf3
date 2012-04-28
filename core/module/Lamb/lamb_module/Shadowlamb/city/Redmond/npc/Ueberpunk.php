<?php
final class Redmond_Ueberpunk extends SR_NPC
{
	public function getNPCPlayerName() { return 'Ueberpunk'; }
	public function getNPCLevel() { return 9; }
	public function getNPCMeetPercent(SR_Party $party) { return 10.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Redmond_Ueberpunk');
		if ( ($quest->isInQuest($player)) && (false === $player->getInvItemByName('UeberpunkHead')) ) {
			return array('UeberpunkHead');
		}
		return array();
	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresPredator',
			'armor' => 'Clothes',
			'legs' => 'Trousers',
			'boots' => 'Sneakers',
		);
	}
	public function getNPCInventory() { return array('FirstAid', 'Ammo_9mm'); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => rand(20, 30),
			'base_hp' => rand(8, 12),
			'strength' => rand(2, 3),
			'quickness' => rand(2, 3),
			'distance' => rand(8, 10),
			'firearms' => rand(1, 3),
			'pistols' => rand(2, 3),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$key = 'RED_FIR_UBE_SCR';
		if ('0' === SR_PlayerVar::getVal($player, $key, '0'))
		{
			SR_PlayerVar::setVal($player, $key, '1');
			return array('ScrollOfWisdom');
		}
		return array();
	}
}
?>