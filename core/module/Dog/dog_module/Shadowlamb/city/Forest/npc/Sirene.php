<?php
final class Forest_Sirene extends SR_NPC
{
	public function getNPCLevel() { return 30; }
	public function getNPCPlayerName() { return 'Sirene'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'SireneSkin',
// 			'helmet' => 'DemonHelmet',
// 			'boots' => 'DemonBoots',
			'legs' => 'SireneLegs',
			'weapon' => array('SirenePike'),
// 			'shield' => 'DemonShield',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'elve',
			'gender' => 'female',
			'melee' => rand(12, 14),
// 			'ninja' => rand(4, 6),
			'strength' => rand(8, 12),
			'quickness' => rand(5, 10),
			'distance' => rand(6, 8),
			'sharpshooter' => rand(6, 10),
			'nuyen' => rand(20, 60),
			'base_hp' => rand(45, 55),
			'magic' => rand(8, 12),
			'intelligence' => rand(7, 8),
			'wisdom' => rand(6, 8),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'heal' => 3,
			'poison_dart' => 5,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		return array();
	}
}
?>
