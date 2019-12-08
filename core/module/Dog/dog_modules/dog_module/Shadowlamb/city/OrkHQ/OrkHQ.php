<?php
final class OrkHQ extends SR_Dungeon
{
	public function getCityLocation() { return 'Redmond_OrkHQ'; }
	public function getImportNPCS() { return array('Redmond_ToughGuy','Redmond_Ork', 'Redmond_Orc_Shamane', 'Redmond_OrkLeader'); }
	public function getArriveText(SR_Player $player) { return 'You enter the ork headquarters. It smells like rotten beef here. You can taste fear now...'; }
	public function getSquareKM() { return 0.4; }
	public function getExploreTime() { return 60; }
	public function getGotoTime() { return 50; }
	public function getAreaSize() { return 100; }
}
