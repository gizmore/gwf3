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
	public function getAreaSize() { return 100; }
	
	public function getMinLevel()
	{
		if (false === ($loc = Shadowrun4::getLocationByTarget($this->getCityLocation())))
		{
			return -1;
		}
		
		if (false === ($city = $loc->getCityClass()))
		{
			return -1;
		}
		
		return $city->getMinLevel();
	}
	
	#############
	### Alert ###
	#############
	public function getAlertKey(SR_Party $party)
	{
		return sprintf('__dung_%s_alert_%s', get_class($this), $party->getID());
	}
	
	public function isAlert(SR_Party $party)
	{
		return $party->setTemp($this->getAlertKey($party), 0) > Shadowrun4::getTime();
	}
	
	public function setAlert(SR_Party $party, $duration=600, $announce=true)
	{
		$party->setTemp($this->getAlertKey($party), Shadowrun4::getTime() + $duration);
		if ($announce)
		{
			$party->ntice('5021');
// 			$party->notice(sprintf('You hear the alarm sound!'));
		}
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$party->unsetTemp($this->getAlertKey($party));
		parent::onCityEnter($party);
	}
	
	/**
	 * Get the city location for a dungeon.
	 * @return string @example 'Redmond_Hotel'
	 */
	abstract public function getCityLocation();
}
?>
