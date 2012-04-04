<?php
final class Seattle_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Seattle_Passenger'); }
	public function getFoundPercentage() { return 100.00; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found the Seattle subway. You can travel to other cities from here.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Redmond_Subway', 100, Redmond::TIME_TO_SEATTLE, 0),
			array('Delaware_Subway', 200, Seattle::TIME_TO_DELAWARE, 15),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		
		$c = Shadowrun4::SR_SHORTCUT;
		$party = $player->getParty();
		$this->partyMessage($player, 'enter');
		$party->getLeader()->help($this->lang($player, 'help2'));
		$this->partyHelpMessage($player, 'help');
		
// 		$party->notice('You enter the Subway and move to the tracks. You see one passenger waiting for a train.');
// 		$party->getLeader()->help("Use {$c}travel 1 to travel to Redmond.");
// 		$party->help("Use {$c}talk <topic> to talk to the passenger.");
	}
}
?>
