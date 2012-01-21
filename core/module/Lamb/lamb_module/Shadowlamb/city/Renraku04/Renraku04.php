<?php
final class Renraku04 extends SR_Dungeon
{
	public function getCityLocation() { return 'Seattle_Renraku'; }
	public function getArriveText() { return 'The elevator stops at Renraku floor 4. You can hear the alarm sound. Seems like your visit got detected.'; }
	public function getGotoTime() { return 200; }
	public function getExploreTime() { return 240; }

	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Prison')->getRespawnLocation($player);
	}
	
	public function onCityEnter(SR_Party $party)
	{
// 		$this->setAlert($party, GWF_Time::ONE_HOUR*3);
		return parent::onCityEnter($party);
	}
}
?>