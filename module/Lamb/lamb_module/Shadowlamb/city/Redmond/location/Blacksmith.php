<?php
final class Redmond_Blacksmith extends SR_Blacksmith
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_BlackDwarf'); }
	public function getFoundPercentage() { return 50.00; }
	public function getFoundText(SR_Player $player) { return 'You find a small store, "The Blacksmith". It seems like they can upgrade your equipment here.'; }
	
//	public function getCommands(SR_Player $player)
//	{
//		$quest = SR_Quest::getQuest($player, 'Redmond_Blacksmith');
//		return $quest->isDone($player) ? parent::getCommands($player) : array('view','buy','sell');
//	}
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Rune_of_strength:0.5', 100.0, 1200),
			array('Rune_of_quickness:0.5', 100.0, 1800),
			array('Rune_of_melee:0.2', 100.0, 2400),
		);
	}

	public function getSimulationPrice() { return 125; }
	public function getUpgradePrice() { return 250; }
	public function getUpgradePercentPrice() { return 15.00; }
}
?>