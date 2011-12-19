<?php
final class Chicago_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Chicago_SubwayGuy'); }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Subway. You can travel to other cities from here.'; }
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Delaware_Subway', 400, Delaware::TIME_TO_CHICAGO, 14),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		
		$c = Shadowrun4::SR_SHORTCUT;
		$party = $player->getParty();
		$party->notice('You enter the Subway and move to the tracks. You see one passenger waiting for a train.');
		$party->getLeader()->help("Use {$c}travel 1 to travel back to Seattle.");
		$party->help("Use {$c}talk <topic> to talk to the passenger.");
	}
}
?>