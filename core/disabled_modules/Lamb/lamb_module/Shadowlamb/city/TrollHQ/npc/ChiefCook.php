<?php
final class TrollHQ_ChiefCook extends SR_NPC
{
	public function getNPCLevel() { return 18; }
	public function getNPCPlayerName() { return 'CookingTroll'; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'melee' => rand(6, 7),
			'sharpshooter' => rand(4, 5),
			'quickness' => rand(3, 4),
			'base_hp' => rand(22, 26),
			'distance' => rand(1, 3),
			'nuyen' => rand(40, 80),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('SamuraiSword'),
			'armor' => 'StuddedVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'LeatherCap',
			'legs' => 'LeatherLegs',
		);
	}
}
?>