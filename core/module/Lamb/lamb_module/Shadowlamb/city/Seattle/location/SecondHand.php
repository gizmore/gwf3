<?php
final class Seattle_SecondHand extends SR_SecondHandStore
{
	public function getMaxItems() { return 25; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_SecondHandDwarf'); }
	public function getFoundPercentage() { return 40.00; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a SecondHandStore in Seattle, nice :)'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the second hand store. A dwarf is behind the counter and greets you.'; }
}
?>
