<?php
final class TrollHQ extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_TrollHQ'; }
	public function getArriveText() { return "You enter the troll HQ."; }
	
	public function getImportNPCS() { return array('Delaware_Ork','Delaware_Troll','Delaware_Goth'); }

	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
	}
}
?>