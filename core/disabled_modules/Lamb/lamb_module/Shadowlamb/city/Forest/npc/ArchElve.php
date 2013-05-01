<?php
final class Forest_ArchElve extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'ArchElve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 12.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'DemonVest',
			'boots' => 'LeatherBoots',
			'legs' => 'DemonLegs',
			'weapon' => 'ElvenStaff',
			'shield' => 'DemonShield',
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'fireball' => 4,
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => rand(5, 9),
			'strength' => rand(5, 7),
			'quickness' => rand(8, 10),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(4, 8),
			'nuyen' => 0,
			'base_hp' => rand(20, 55),
			'magic' => rand(8, 12),
			'intelligence' => rand(6, 8),
			'wisdom' => rand(4, 8),
		);
	}
}
?>
