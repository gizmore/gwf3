<?php
final class Forest_BigBanshee extends SR_NPC
{
	public function getNPCLevel() { return 32; }
	public function getNPCPlayerName() { return 'Undine'; }
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
			'melee' => rand(10, 12),
			'swordsman' => rand(4, 8),
			'viking' => rand(4, 8),
			'strength' => rand(10, 12),
			'quickness' => rand(8, 10),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(8, 12),
			'nuyen' => rand(60, 130),
			'base_hp' => rand(50, 80),
			'magic' => rand(9, 12),
			'intelligence' => rand(9, 12),
			'wisdom' => rand(6, 12),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'poison_dart' => 6,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		return array();
	}
}
?>
