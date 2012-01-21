<?php
/**
 * A relative small building
 * @author gizmore
 */
final class NySoft extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_NySoft'; }
	public function getArriveText() { return 'You enter the NySoft office. Quite small but impressive building.'; }
	public function getGotoTime() { return 120; }
	public function getExploreTime() { return 160; }
	
	public function getMinLevel() { return 20; }
	
	public function getImportNPCS() { return array('Seattle_BlackOp'); }
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
	
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Prison')->getRespawnLocation($player);
	}
	
}
?>