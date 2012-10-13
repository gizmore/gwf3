<?php
final class Forest_MonsterWerewolf extends SR_NPC
{
	public function getNPCLevel() { return 24; }
	public function getNPCPlayerName() { return 'MonsterWerewolf'; }
	public function getNPCMeetPercent(SR_Party $party) { return 3.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Claws',
			'armor' => 'LeatherVest',
			'legs' => 'StuddedLegs',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'animal',
			'gender' => 'male',
			'melee' => rand(19, 24),
			'ninja' => rand(15, 19),
			'strength' => rand(11, 14),
			'quickness' => rand(8, 11),
			'distance' => rand(2, 4),
			'sharpshooter' => rand(9, 14),
			'nuyen' => 0,
			'base_hp' => rand(60, 80),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Farmer');
		if ($quest->isInQuest($player))
		{
			$quest->increaseAmount(1);
			$quest->msg('kills', array($quest->getAmount(), $quest->getNeededAmount()));
			if ($quest->getAmount() === 2)
			{
				return array('KylesAmulet');
			}
		}
		return array();
	}
}
?>
