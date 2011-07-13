<?php
final class Delaware_Goblin extends SR_NPC
{
	public function getNPCLevel() { return 14; }
	public function getNPCPlayerName() { return 'Goblin'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'gnome',
			'strength' => rand(2, 3),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(2, 3),
			'quickness' => rand(3, 4),
			'base_hp' => rand(12, 15),
			'distance' => rand(1, 3),
			'nuyen' => rand(20, 60),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('Knife'),
			'armor' => 'LeatherVest',
			'boots' => 'Shoes',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Delaware_DallasJ2');
		if ($quest->isInQuest($player))
		{
			$quest->increase('sr4qu_amount', 1);
			$player->message(sprintf('Now you killed %d goblins for Mr.Johnson.', $quest->getAmount()));
		}
		return array();
	}
}
?>