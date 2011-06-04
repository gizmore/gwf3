<?php
final class Renraku_Room2 extends SR_SearchRoom
{
	public function isLocked() { return true; }
	public function getLockLevel() { return 1.0; }

	public function isSearchable() { return true; }
	public function getSearchLevel() { return 8; }
	public function getSearchMaxAttemps() { return 3; }
	 
	public function getFoundPercentage() { return 50; }
	public function getFoundText(SR_Player $player) { return "This room seems locked."; }
	public function getEnterText(SR_Player $player) { return "You enter a quite large storage room."; }
}
?>