<?php
final class Redmond_Snowman extends SR_NPC
{
	public function getNPCLevel() { return 2; }
	public function getNPCPlayerName() { return 'Snowman'; }
	public function getNPCMeetPercent(SR_Party $party) { return 15.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player) { return array(); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('Club'),
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => 0,
			'base_hp' => rand(5, 35),
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
		$got = SR_PlayerVar::getVal($player, '2012_SNO', 0);
		
		if ($got >= 15)
		{
			return array();
		}
		
		SR_PlayerVar::increaseVal($player, '2012_SNO', 1);
		
		return array('Present');
		
	}
	
}
?>