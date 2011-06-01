<?php
final class Seattle_Garage extends SR_Location
{
	public function getFoundPercentage() { return 0.0; }
	public function getFoundText(SR_Player $player) { return 'You found a small pub, called "The Garage".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the pub, and see a few people: A Johnson, an elve and the barkeeper.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb, {$c}ttj and {$c}tte here."; }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Seattle_GBarkeeper','ttj'=>'Seattle_GJohnson','tte'=>'Seattle_GElve'); }
}
?>