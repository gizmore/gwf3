<?php
final class Harbor_Depot2 extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) { return 'You enter the depot. It is mostly empty, but you see some garbage in old crates.'; }
	public function getFoundText(SR_Player $player) { return 'You found a big Depot labeled "Depot2".'; }
	public function getFoundPercentage() { return 50.0; }
	public function getSearchMaxAttemps() { return 2; }
	public function getSearchLevel() { return 3; }
}
?>