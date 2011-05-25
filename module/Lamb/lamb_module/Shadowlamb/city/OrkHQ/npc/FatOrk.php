<?php
final class OrkHQ_FatOrk extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'FatOrk'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'gender' => 'male',
			'strength' => rand(6, 9),
			'quickness' => rand(1, 2),
			'melee' => rand(4, 7),
			'base_hp' => rand(8, 12),
			'distance' => rand(0, 3),
			'nuyen' => rand(0, 45),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ButchersKnife',
			'armor' => 'LeatherVest',
			'boots' => 'Sandals',
		);
	}
	
	public function getNPCInventory()
	{
		return array('Bacon');
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		if (rand(1, 10) <= 5) {
			return array('Bacon');
		} 
		return array();
	}
}
?>