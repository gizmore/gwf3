<?php
require_once 'SR_City.php';

/**
 * Abstract dungeon class. Features alarm clock.
 * @author gizmore
 * @version 3.0
 * @since 3.0
 * @see SR_City
 */
abstract class SR_Dungeon extends SR_City
{
	public function isDungeon() { return true; }
	
	#############
	### Alert ###
	#############
	private $alert = array();
	
	public function isAlert(SR_Party $party)
	{
		$pid = $party->getID();
		return isset($this->alert[$pid]) && $this->alert[$pid] > Shadowrun4::getTime();
	}
	
	public function setAlert(SR_Party $party, $duration=600)
	{
		$pid = $party->getID();
		$this->alert[$pid] = Shadowrun4::getTime() + $duration;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$this->setAlert($party, 0);
		parent::onCityEnter($party);
	}
}
?>
