<?php
final class Harbor extends SR_Dungeon
{
	public function getImportNPCS() { return array('Redmond_Ueberpunk','Seattle_Ninja','Seattle_TrollDecker','Seattle_Robber','Seattle_Killer'); }
	public function getArriveText() { return 'You enter the Seattle Harbor. You see a lot of Depots and some bigger ships that are beeing loaded and unloaded.'; }
	public function getSquareKM() { return 3; }
	public function getExploreTime() { return 250; }
	public function getGotoTime() { return 240; }
}
?>