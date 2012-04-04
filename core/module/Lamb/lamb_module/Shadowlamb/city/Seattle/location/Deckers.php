<?php
final class Seattle_Deckers extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Seattle_DBarkeeper', 'ttj'=>'Seattle_DJohnson', 'ttm'=>'Seattle_HireMagician', 'tte'=>'Seattle_DElve'); }
	public function getFoundPercentage() { return 50.0; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a pub called "Deckers". It seems like a nice place to rest and drink.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Deckers pub and see a few guests. The pub seems clean and they even have a live band playing.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttj, {$c}ttm, {$c}tte and {$c}ttb here."; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>