<?php
final class WestVegas_Subway extends SR_Subway
{
// 	public function getNPCS(SR_Player $player) { return array('talk' => 'WestVegas_Passenger'); }
	public function getFoundPercentage() { return 100.00; }
// 	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Redmond_Subway', 100, Redmond::TIME_TO_VEGAS, 0),
			array('Seattle_Subway', 200, Seattle::TIME_TO_VEGAS, 15),
			array('Delaware_Subway', 200, Delaware::TIME_TO_VEGAS, 15),
			array('Chicago_Subway', 200, Chicago::TIME_TO_VEGAS, 15),
			array('WestVegas_Subway', 200, WestVegas::TIME_TO_VEGAS, 15),
		);
	}
	
// 	public function onEnter(SR_Player $player)
// 	{
// 		parent::onEnter($player);
	
// 		$c = Shadowrun4::SR_SHORTCUT;
// 		$party = $player->getParty();
// 		$this->partyMessage($player, 'enter');
// 		$party->getLeader()->help($this->lang($player, 'help2'));
// 		$this->partyHelpMessage($player, 'help');
// 	}
}
?>