<?php
final class Delaware_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Delaware_Passenger'); }
	public function getFoundPercentage() { return 100.00; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found the Subway. You can travel to other cities from here.'; }
// 	public function getEnterText(SR_Player $player) { return "You enter the Subway and move to the tracks. You see one passenger waiting for a train."; }
// 	public function getHelpText(SR_Player $player) { return "Use #travel 1 to travel back to Seattle. Use #talk <topic> to talk to the passenger."; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Seattle_Subway', 200, Seattle::TIME_TO_DELAWARE, 8),
			array('Chicago_Subway', 400, Delaware::TIME_TO_CHICAGO, 21),
		);
	}
}
?>
