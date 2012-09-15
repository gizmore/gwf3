<?php
final class Chicago_Blacksmith extends SR_Blacksmith
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_BlackSmithSmith', 'tt2' => 'Chicago_BlackSmithSalesman'); }
	public function getFoundPercentage() { return 25.00; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('ShortSword', 100.0, 1000),
			array('BroadSword', 100.0, 1500),
			array('LongSword', 100.0, 2000),
			array('Katana', 100.0, 4000),
		);
	}

	public function getSimulationPrice() { return 175; }
	public function getUpgradePrice() { return 350; }
	public function getUpgradePercentPrice() { return 15.50; }

	public function getUpgradeFailModifier() { return 2.4; }
	public function getUpgradeBreakModifier() { return 0.9; }
	
	public function getBreakPrice(SR_Player $player)
	{
		return $player->hasSolvedQuest('Chicago_BlackSmith1') ? 0 : parent::getBreakPrice($player);
	}
	
	public function getBreakPercentPrice(SR_Player $player)
	{
		return $player->hasSolvedQuest('Chicago_BlackSmith1') ? 0 : parent::getBreakPercentPrice($player);
	}
}
?>
