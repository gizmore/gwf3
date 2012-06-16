<?php
final class Redmond_Lamer extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Lamer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 200.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Redmond_Johnson_1');
		if ($quest->isInQuest($player))
		{
			$quest->increaseAmount(1);
			$player->message(sprintf('Now you killed %d Lamers for Mr.Johnson.', $quest->getAmount()));
		}
		return array();
	}
	public function getNPCEquipment()
	{
		return array(
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers()
	{
		return array(
			'nuyen' => rand(10, 20),
			'base_hp' => rand(-8, -6),
			'distance' => rand(0, 2),
			'strength' => 1,
			'quickness' => 1,
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => -0.2,
			'max_dmg' => -1.0,
			'attack' => -0.4,
		);
	}
	
}
?>