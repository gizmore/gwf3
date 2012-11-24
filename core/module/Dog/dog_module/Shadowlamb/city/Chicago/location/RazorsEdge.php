<?php
final class Chicago_RazorsEdge extends SR_Location
{
	public function getFoundPercentage() { return 25.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Chicago_RazorBarkeeper','ttj'=>'Chicago_RazorJohnson'); }
}
?>
