<?php
final class Forest_Banshee extends SR_NPC
{
	public function getNPCLevel() { return 28; }
	public function getNPCPlayerName() { return 'Banshee'; }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'DemonVest',
			'helmet' => 'DemonHelmet',
			'boots' => 'DemonBoots',
			'legs' => 'DemonLegs',
			'weapon' => array('DemonSword', 'DemonAxe'),
			'shield' => 'DemonShield',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'gender' => 'female',
			'melee' => rand(8, 10),
			'ninja' => rand(4, 6),
			'strength' => rand(9, 11),
			'quickness' => rand(6, 9),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(5, 12),
			'nuyen' => rand(30, 110),
			'base_hp' => rand(40, 50),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		if (rand(0,1))
		{
			return array('BlackOrchid');
		}
		return array();
	}
}
?>
