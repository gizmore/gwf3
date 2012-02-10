<?php
final class Hideout extends SR_Dungeon
{
	public function getCityLocation() { return 'Redmond_Hideout'; }
	public function getImportNPCS() { return array('Redmond_Lamer','Redmond_Cyberpunk'); }
	public function getArriveText(SR_Player $player) { return 'You enter the rotten building. It smells not good but you can breathe. You feel clumsy.'; }
	public function getSquareKM() { return 0.2; }
	public function getExploreTime() { return 60; }
	public function getGotoTime() { return 50; }
}
?>