<?php
final class Seattle_AngryElve extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Angry Elve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
//	public function getNPCLoot(SR_Player $player) { return array('Cake'); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ElvenBow',
			'armor' => 'ElvenVest',
			'legs' => 'ElvenShorts',
		);
	}
	public function getNPCInventory() { return array('Ammo_Arrow', 'Ammo_Arrow'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'woodelve',
			'gender' => 'male',
			'strength' => rand(1, 3),
			'quickness' => rand(4, 5),
			'distance' => rand(8, 14),
			'bows' => rand(3, 5),
			'firearms' => rand(2, 4),
			'sharpshooter' => rand(4, 8),
			'nuyen' => rand(50, 80),
			'base_hp' => rand(4, 10),
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