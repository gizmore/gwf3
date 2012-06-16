<?php
final class Forest_ZombieBear extends SR_NPC
{
	public function getNPCLevel() { return 30; }
	public function getNPCPlayerName() { return 'ZombieBear'; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		$player = $party->getLeader();
		$quest = SR_Quest::getQuest($player, 'Seattle_Ranger');
		return $quest->getAmount() > 0 ? 70 : 0;
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Claws',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'animal',
			'gender' => 'male',
			'melee' => rand(20, 24),
			'ninja' => rand(12, 16),
			'strength' => rand(11, 14),
			'quickness' => rand(4, 7),
			'distance' => rand(8, 12),
			'sharpshooter' => rand(9, 12),
			'nuyen' => 0,
			'base_hp' => rand(80, 120),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Ranger');
		$quest instanceof Quest_Seattle_Ranger;
		if ($quest->isInQuest($player))
		{
			$quest->increaseAmount(1);
		}
	}
}
?>
