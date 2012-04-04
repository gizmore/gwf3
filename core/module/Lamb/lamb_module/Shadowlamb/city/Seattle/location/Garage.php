<?php
final class Seattle_Garage extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Seattle_GBarkeeper','ttj'=>'Seattle_GJohnson','tte'=>'Seattle_HireDecker'); }
	public function getFoundPercentage() { return 40.00; }

// 	public function getFoundText(SR_Player $player) { return 'You found a small pub, called "The Garage".'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the pub, and see a few people: a Johnson, an elve and the barkeeper.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb, {$c}ttj and {$c}tte here."; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
