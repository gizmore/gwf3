<?php
final class Renraku_Room3 extends SR_SearchRoom
{
	public function isLocked() { return true; }
	public function getLockLevel() { return 2.0; }

	public function isSearchable() { return true; }
	public function getSearchLevel() { return 9; }
	public function getSearchMaxAttemps() { return 2; }
	 
	public function getFoundPercentage() { return 50; }
	public function getFoundText(SR_Player $player) { return "This room is locked."; }
	public function getEnterText(SR_Player $player) { return "You enter another storage room."; }
}
?>