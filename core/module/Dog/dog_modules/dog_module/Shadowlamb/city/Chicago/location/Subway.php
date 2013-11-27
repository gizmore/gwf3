<?php
final class Chicago_Subway extends SR_Subway
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Chicago_SubwayGuy'); }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the Subway. You can travel to other cities from here.'; }
	public function getEnterText(SR_Player $player) { return "You enter the Subway and move to the tracks. You see one passenger waiting for a train."; }
	public function getHelpText(SR_Player $player) { return "Use #travel 1 to travel back to Delaware. Use #talk <topic> to talk to the passenger."; }
	public function getSubwayTargets(SR_Player $player)
	{
		return array(
			array('Delaware_Subway', 400, Delaware::TIME_TO_CHICAGO, 14),
		);
	}
}
?>