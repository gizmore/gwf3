<?php
final class Seattle_AngryElve extends SR_NPC
{
	public function getNPCLevel() { return 9; }
	public function getNPCPlayerName() { return 'Angry Elve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
//	public function canNPCMeet(SR_Party $party) { return true; }
//	public function getNPCLoot(SR_Player $player) { return array('Cake'); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ElvenBow',
			'armor' => 'ElvenVest',
			'legs' => 'ElvenShorts',
			'boots' => 'ElvenBoots',
		);
	}
	public function getNPCInventory() { return array('Ammo_Arrow', 'Ammo_Arrow'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'woodelve',
			'gender' => 'male',
			'strength' => rand(3, 4),
			'quickness' => rand(6, 7),
			'distance' => rand(8, 12),
			'bows' => rand(4, 6),
			'firearms' => rand(4, 6),
			'sharpshooter' => rand(3, 8),
			'nuyen' => rand(50, 120),
			'base_hp' => rand(6, 11),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Archery');
		if ($quest->isInQuest($player))
		{
			$quest->increase('sr4qu_amount', 1);
			$player->message(sprintf('Now you killed %d Angry Elves for the Archery Quest.', $quest->getAmount()));
		}
		return array();
	}
	
}
?>