<?php
final class Renraku03 extends SR_City
{
	public function getCityLocation() { return 'Seattle_Renraku'; }
	public function isDungeon() { return true; }
	public function getArriveText() { return 'The elevator stops at Renraku floor 3.'; }
	public function getGotoTime() { return 120; }
	public function getExploreTime() { return 160; }

	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
}
?>