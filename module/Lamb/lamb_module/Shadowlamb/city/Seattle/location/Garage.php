<?php
final class Seattle_Garage extends SR_Location
{
	public function getFoundText(SR_Player $player) { return 'You found a small pub, called "The Garage".'; }
	public function getFoundPercentage() { return 0.0; }
	public function getEnterText(SR_Player $player) { return 'You enter the pub, nothings up here.'; }
	public function getHelpText(SR_Player $player) { return "You can use {$c}ttb here."; }
}
?>