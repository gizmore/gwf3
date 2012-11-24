<?php
final class Chicago_SecondHand extends SR_SecondHandStore
{
	public function getMaxItems() { return 30; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_SecondHandDwarf'); }
	public function getFoundPercentage() { return 40.00; }
	public function getFoundText(SR_Player $player) { return 'You found a SecondHandStore, nice :)'; }
	public function getEnterText(SR_Player $player) { return 'You enter the second hand store. A salesman is behind the counter and greets you.'; }
}
?>