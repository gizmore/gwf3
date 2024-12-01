<?php
final class Seattle_AngryElve extends SR_NPC
{
	public function getNPCLevel() { return 10; }
	public function getNPCPlayerName() { return 'AngryElve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('ElvenBow', 'Fists', 'Stiletto')
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
			'strength' => rand(1, 3),
			'quickness' => rand(3, 5),
			'distance' => rand(8, 14),
			'melee' => rand(1, 3)
			'bows' => rand(1, 3),
			'firearms' => rand(1, 3),
			'sharpshooter' => rand(1, 2),
			'nuyen' => rand(40, 70),
			'base_hp' => rand(4, 9),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Archery');
		if ($quest->isInQuest($player))
		{
			$quest->increase('sr4qu_amount', 1);
			$player->message($quest->lang('kill', array($quest->getAmount(), $quest->getNeededAmount())));
// 			$player->message(sprintf('Now you killed %d Angry Elves for the Archery Quest.', $quest->getAmount()));
		}
		return array();
	}
	
}
