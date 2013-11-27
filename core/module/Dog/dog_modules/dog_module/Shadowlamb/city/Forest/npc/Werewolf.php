<?php
final class Forest_Werewolf extends SR_NPC
{
	public function getNPCLevel() { return 19; }
	public function getNPCPlayerName() { return 'Werewolf'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	
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
			'melee' => rand(16, 18),
			'ninja' => rand(9, 16),
			'strength' => rand(9, 11),
			'quickness' => rand(6, 9),
			'distance' => rand(8, 12),
			'sharpshooter' => rand(7, 12),
			'nuyen' => 0,
			'base_hp' => rand(30, 40),
		);
	}
}
?>
