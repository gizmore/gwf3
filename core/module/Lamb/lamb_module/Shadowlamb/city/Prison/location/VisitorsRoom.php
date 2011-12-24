<?php
final class Prison_VisitorsRoom extends SR_Location
{
	public function getFoundPercentage() { return 25; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'Prison_VisitMalois'); }
	public function isEnterAllowed(SR_Player $player) { return $player->hasTemp('PSTIDVIS'); }
	public function getEnterText(SR_Player $player) { return "You enter the visitors room and spot Malois approaching behind the glass windows."; }
	public function getFoundText(SR_Player $player) { return "It seems you found the visitors room for the imprisoned part of the society."; }
	public function getHelpText(SR_Player $player) { return "Use #talk to talk with Malois."; }
}
?>