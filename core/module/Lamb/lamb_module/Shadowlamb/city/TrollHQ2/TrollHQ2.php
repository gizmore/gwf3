<?php
final class TrollHQ2 extends SR_Dungeon
{
	public function getArriveText() { return "You enter the 2nd floor ..."; }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
	}
}
?>