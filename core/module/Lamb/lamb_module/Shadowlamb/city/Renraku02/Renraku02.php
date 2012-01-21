<?php
final class Renraku02 extends SR_Dungeon
{
	public function getCityLocation() { return 'Seattle_Renraku'; }
	public function getArriveText() { return 'The elevator stops at Renraku floor 2.'; }
	public function getGotoTime() { return 120; }
	public function getExploreTime() { return 160; }

	public function getImportNPCS()
	{
		return array(
			'Renraku04_Security',
		);
	}
	
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
}
?>