<?php
final class Seattle_RottenHome extends SR_Location
{
	public function getFoundText(SR_Player $player) { return "You found a rottom home and hear a weird monologue from the inside."; }
	public function getEnterText(SR_Player $player) { return "The front door is open and you sneak in. There is a crazy man on the floor."; }
	public function getFoundPercentage() { return 20.00; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'Seattle_TomRiddle'); }
}
?>