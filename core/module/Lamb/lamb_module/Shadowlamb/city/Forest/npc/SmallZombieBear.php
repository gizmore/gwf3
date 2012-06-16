<?php
final class Forest_SmallZombieBear extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'SmallZombieBear'; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Ranger');
		return $quest->getAmount() > 0 ? 90 : 0;
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
			'melee' => rand(18, 24),
			'ninja' => rand(6, 9),
			'strength' => rand(5, 12),
			'quickness' => rand(3, 8),
			'distance' => rand(6, 12),
			'sharpshooter' => rand(4, 8),
			'nuyen' => 0,
			'base_hp' => rand(50, 70),
		);
	}
}
?>
