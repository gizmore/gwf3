<?php
final class Redmond_Snowman extends SR_NPC
{
	public function getNPCLevel() { return 2; }
	public function getNPCPlayerName() { return 'Snowman'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; } // Toggle here (was 10.00)
	public function canNPCMeet(SR_Party $party) { return false; } // Toggle here
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
			'base_hp' => rand(70, 140),
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
		$got = SR_PlayerVar::getVal($player, '2016_SNO', 0);
		
		if ($got >= 20)
		{
			return array();
		}
		
		SR_PlayerVar::increaseVal($player, '2016_SNO', 1);
		
		return array('Present');
		
	}
	
}
?>
