<?php
final class Delaware_Dallas extends SR_Location
{
	public function getFoundPercentage() { return 80.00; }
	public function getFoundText(SR_Player $player) { return "You found a disco, the 'Dallas'. Quite some noise inside."; }
	public function getEnterText(SR_Player $player) { return 'You enter the pub, and see a few people: A Johnson, an elve and the barkeeper.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb, {$c}ttj and {$c}ttq here."; }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Dalaware_DBarkeeper','ttj'=>'Dalaware_DJohnson'); }
}
?>