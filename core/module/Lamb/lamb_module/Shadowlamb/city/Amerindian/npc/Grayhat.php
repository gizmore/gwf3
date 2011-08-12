<?php
final class Amerindian_Grayhat extends SR_NPC
{
	public function getNPCLevel() { return 16; }
	public function getNPCPlayerName() { return 'Grayhat'; }
	public function getNPCMeetPercent(SR_Party $party) { return 10.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'FineStaff',
			'armor' => 'FineRobe',
			'legs' => 'FineLegs',
			'boots' => 'FineBoots',
		);
	}
	public function getNPCInventory() { return array('FirstAid'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'woodelve',
			'gender' => 'male',
			'base_hp' => rand(14, 20),
			'base_mp' => rand(20, 60),
			'nuyen' => rand(50, 120),
			'distance' => rand(8, 12),
		
			'body' => rand(2, 3),
			'magic' => rand(6, 10),
			'strength' => rand(2, 4),
			'melee' => rand(2, 4),
			'quickness' => rand(4, 6),
			'intelligence' => rand(8, 12),
			'wisdom' => rand(8, 12),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'firebolt' => 4,
			'magicarp' => 2,
			'blow' => 2,
		); 
	}
}
?>