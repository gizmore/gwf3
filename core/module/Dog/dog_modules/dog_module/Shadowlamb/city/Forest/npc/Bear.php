<?php
final class Forest_Bear extends SR_NPC
{
	public function getNPCLevel() { return 17; }
	public function getNPCPlayerName() { return 'Bear'; }
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
			'melee' => rand(8, 10),
			'ninja' => rand(4, 6),
			'strength' => rand(9, 11),
			'quickness' => rand(6, 9),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(5, 12),
			'nuyen' => 0,
			'base_hp' => rand(50, 60),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		return array('Fur', 'RawMeat');
	}
}
?>
