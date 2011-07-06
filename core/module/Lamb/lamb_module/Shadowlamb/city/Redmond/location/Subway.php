<?php
final class Redmond_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Redmond_Passenger'); }
//	public function getCommands(SR_Player $player) { return array('travel'); }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Redmond subway. You can travel to other cities from here.'; }
	
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Seattle_Subway', 100, 300, 8),
//			array('Delaware_Subway', 200, 600, 12),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		
		$c = Shadowrun4::SR_SHORTCUT;
		$party = $player->getParty();
		$party->notice('You enter the Subway and move to the tracks. You see a train to Seattle, and a passenger.');
		$party->getLeader()->help("Use {$c}travel 1 to travel to Seattle or just {$c}travel to see all trains.");
		$party->help("Use {$c}talk <topic> to talk to the passenger.");
	}
}
?>