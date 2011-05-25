<?php
final class OrkHQ extends SR_City
{
	public function isDungeon() { return true; }
	public function getImportNPCS() { return array('Redmond_ToughGuy','Redmond_Ork','Redmond_OrkLeader'); }
	public function getArriveText() { return 'You enter the ork headquarters. It smells like rotten beef here. You can taste fear now...'; }
	public function getSquareKM() { return 0.4; }
	public function getExploreTime() { return 50; }
	public function getGotoTime() { return 40; }
}
?>