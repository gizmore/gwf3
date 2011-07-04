<?php
final class Nysoft extends SR_Dungeon
{
	public function getArriveText() { return 'You enter the Nysoft office. Quite impressive building.'; }
	public function getGotoTime() { return 120; }
	public function getExploreTime() { return 160; }
	
//	/**
//	 * Get the renraku main elevator.
//	 * @return Renraku_Elevator
//	 */
//	public function getRenrakuElevator()
//	{
//		return $this->getLocation('Elevator');
//	}
	
	/**
	 * @param SR_Party $party
	 */
	public function onCityEnter(SR_Party $party)
	{
//		$this->getRenrakuElevator()->setElevatorFlagsDefault($party);
		parent::onCityEnter($party);
	}
}
?>