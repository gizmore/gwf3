<?php
final class TrollCellar extends SR_Dungeon
{
	public function getArriveText() { return "You enter the cellar in the troll hq."; }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
	}
}
?>