<?php
final class Redmond_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Redmond_Passenger'); }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Redmond subway. You can travel to other cities from here.'; }
	public function getEnterText(SR_Player $player) { return "You enter the Subway and move to the tracks. You see a train to Seattle, and a passenger."; }
	public function getHelpText(SR_Player $player) { return "Use #talk <topic> to talk to the passenger."; }
	
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Seattle_Subway', 100, Redmond::TIME_TO_SEATTLE, 8),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$c = Shadowrun4::SR_SHORTCUT;
		$party = $player->getParty();
		$party->getLeader()->help("If all party members reached level 8, you can use {$c}travel 1 to travel to Seattle. Use {$c}travel to see all possible targets.");
		return true;
	}
}
?>