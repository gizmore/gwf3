<?php
final class Harbor_Depot4 extends SR_SearchRoom
{
	public function getAreaSize() { return 80; }
	public function getEnterText(SR_Player $player) { return 'You enter the depot. It is mostly empty, but you see some garbage in old crates.'; }
	public function getFoundText(SR_Player $player) { return 'You found a big Depot labeled "Depot4".'; }
	public function getFoundPercentage() { return 50.0; }
	public function getSearchMaxAttemps() { return 3; }
	public function getSearchLevel() { return 4; }
}
?>