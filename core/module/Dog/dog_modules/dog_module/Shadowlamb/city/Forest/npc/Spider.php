<?php
final class Forest_Spider extends SR_NPC
{
	public function getNPCLevel() { return 14; }
	public function getNPCPlayerName() { return 'GiantSpider'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Jaw',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'animal',
			'gender' => 'male',
			'melee' => rand(10, 12),
			'ninja' => rand(4, 6),
			'strength' => rand(9, 11),
			'quickness' => rand(6, 9),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(5, 12),
			'nuyen' => 0,
			'base_hp' => rand(8, 14),
		);
	}
}
?>
