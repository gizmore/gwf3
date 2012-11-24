<?php
final class TrollCellar extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_TrollHQ'; }
	public function getArriveText(SR_Player $player) { return "You enter the cellar in the troll hq."; }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
	}
}
?>