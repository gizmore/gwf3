<?php
final class Redmond_Snowman extends SR_NPC
{
	public function getNPCLevel() { return 2; }
	public function getNPCPlayerName() { return 'Snowman'; }
	public function getNPCMeetPercent(SR_Party $party) { return 10.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array_rand(array('Club', 'DemonSword', 'KnightsSword', 'Knife', 'BaseballBat'), 1),
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => 0,
			'base_hp' => rand(200, 275),
			'strength' => 1,
		);
	}
	public function getNPCModifiersB()
	{
		return array(
			'min_dmg' => 0,
			'max_dmg' => 0,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$got = SR_PlayerVar::getVal($player, '2013_SNO', 0);
		
		if ($got >= 20)
		{
			return array();
		}
		
		SR_PlayerVar::increaseVal($player, '2013_SNO', 1);
		
		return array('Present');
		
	}
	
}
?>
