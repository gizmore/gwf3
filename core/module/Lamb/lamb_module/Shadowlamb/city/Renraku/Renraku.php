<?php
final class Renraku extends SR_Dungeon
{
	public function getCityLocation() { return 'Seattle_Renraku'; }
	public function getArriveText() { return 'You enter the Renraku office. "Stay calm", you think by yourself.'; }
	public function getGotoTime() { return 120; }
	public function getExploreTime() { return 160; }
	
	public function getImportNPCS()
	{
		return array(
			'Renraku04_Security',
		);
	}
	
	/**
	 * Get the renraku main elevator.
	 * @return Renraku_Elevator
	 */
	public function getRenrakuElevator()
	{
		return $this->getLocation('Elevator');
	}
	
	/**
	 * @param SR_Party $party
	 */
	public function onCityEnter(SR_Party $party)
	{
		$this->getRenrakuElevator()->setElevatorFlagsDefault($party);
		parent::onCityEnter($party);
	}

	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
}
?>