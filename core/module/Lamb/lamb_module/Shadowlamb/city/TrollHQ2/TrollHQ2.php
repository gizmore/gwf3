<?php
final class TrollHQ2 extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_TrollHQ'; }
	public function getArriveText(SR_Player $player) { return "You enter the 2nd floor ..."; }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
	}
}
?>