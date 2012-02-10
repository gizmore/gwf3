<?php
final class PC_Renraku02_Box4 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 9; }
	public function getComputerLevel(SR_Player $player) { return 1.3; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$quest = SR_Quest::getQuest($player, 'Renraku_II');
		$quest instanceof Quest_Renraku_II;
		$quest->onHackedThree($player);
	}
}

final class Renraku02_Room4 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 90.0; }
	public function getComputers() { return array('Renraku02_Box4'); }
	public function getLockLevel() { return 0.9; }
	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0204. On a desk you see a computer with a screensaver.'; }
	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0204". It seems locked.'; }
}
?>
