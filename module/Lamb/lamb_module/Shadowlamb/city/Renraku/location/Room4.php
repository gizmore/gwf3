<?php
final class PC_RenrakuBOX4 extends SR_Computer
{
	public function getMaxAttempts() { return 5; }
	public function getMinHits() { return 13; }
	public function getComputerLevel(SR_Player $player) { return 1.2; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$party = $player->getParty();
		$player->message(sprintf('This computer is able to activate the elevator to floor2.'));
		$elevator = Shadowrun4::getLocationByTarget('Renraku_Elevator');
		$elevator instanceof Renraku_Elevator;
		$elevator->setElevatorFlagsParty($party, 2, true);
		$party->notice(sprintf('%s managed to unlock the elevator floor 2.', $player->getName()));
	}
	
}

final class Renraku_Room4 extends SR_SearchRoom
{
	public function getComputers() { return array('RenrakuBOX4'); }
	
	public function isLocked() { return true; }
	public function getLockLevel() { return 1.2; }

	public function isSearchable() { return true; }
	public function getSearchLevel() { return 2; }
	public function getSearchMaxAttemps() { return 2; }
	 
	public function getFoundPercentage() { return 50; }
	public function getFoundText(SR_Player $player) { return "You found another locked room."; }
	public function getEnterText(SR_Player $player) { return "You enter a small storage room. In a corner you locate a single computer."; }
}
?>