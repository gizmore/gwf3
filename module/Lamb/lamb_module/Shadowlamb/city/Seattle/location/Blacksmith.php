<?php
final class Seattle_Blacksmith extends SR_Blacksmith
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_BlackDwarf'); }
	public function getFoundPercentage() { return 18.00; }
	public function getFoundText() { return 'Far outside of town you find a very small store, "The Blacksmith". The store seem ruined, but it seems open.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the blacksmith. There is a poor looking dwarf behind the counter.'; }
	
	public function getCommands(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Redmond_Blacksmith');
		return $quest->isDone($player) ? parent::getCommands($player) : array('view','buy','sell');
	}
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Rune_of_strength:0.5', 100.0, 1000),
			array('Rune_of_quickness:0.5', 100.0, 1500),
			array('Rune_of_melee:0.2', 100.0, 2000),
			array('Rune_of_firearms:0.2', 100.0, 2800),
			array('Rune_of_bows:0.2', 100.0, 2800),
		);
	}

	public function getSimulationPrice() { return 125; }
	public function getUpgradePrice() { return 250; }
	public function getUpgradePercentPrice() { return 15.00; }
}
?>