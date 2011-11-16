<?php
final class Renraku03 extends SR_City
{
	public function getCityLocation() { return 'Seattle_Renraku'; }
	public function isDungeon() { return true; }
	public function getArriveText() { return 'Renraku03 TEXT HERE!'; }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
}
?>