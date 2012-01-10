<?php
final class Chicago_RazorsEdge extends SR_Location
{
	public function getFoundPercentage() { return 25.00; }
	public function getFoundText(SR_Player $player) { return "You found a pub called Razors Edge."; }
	public function getEnterText(SR_Player $player) { return 'You enter the pub and there is not much activity. In a corner you assume a local Johnson.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb and {$c}ttj here."; }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Chicago_RazorBarkeeper','ttj'=>'Chicago_RazorJohnson'); }
}
?>
