<?php
final class Delaware_Dallas extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Delaware_DBarkeeper','ttj'=>'Delaware_DJohnson'); }
	public function getFoundPercentage() { return 80.00; }
	
// 	public function getFoundText(SR_Player $player) { return "You found a disco, the 'Dallas'. Quite some noise inside."; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the pub, and see a few people: a Johnson, an elve and the barkeeper.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb and {$c}ttj here."; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
