<?php
final class PC_Renraku02_Box1 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 8; }
	public function getComputerLevel(SR_Player $player) { return 1.2; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$quest = SR_Quest::getQuest($player, 'Renraku_II');
		$quest instanceof Quest_Renraku_II;
		$quest->onHackedOne($player);
	}
}

final class Renraku02_Room1 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 80.0; }
	public function getComputers() { return array('Renraku02_Box1'); }
	public function getLockLevel() { return 0.8; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0201". It seems locked.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0201. On a desk you see a computer with a screensaver.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>
