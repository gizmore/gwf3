<?php
final class Delaware_Troll extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'Troll'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'strength' => rand(3, 4),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(1, 2),
			'quickness' => rand(2, 4),
			'base_hp' => rand(15, 17),
			'distance' => rand(1, 3),
			'nuyen' => rand(25, 50),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('LongSword'),
			'armor' => 'LeatherVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Delaware_DallasJ3');
		if ($quest->isInQuest($player))
		{
			$quest->increaseAmount(1);
			$player->message(sprintf('Now you killed %d of %d trolls for Mr.Johnson.', $quest->getAmount(), $quest->getNeededAmount()));
		}
		return array();
	}
}
?>