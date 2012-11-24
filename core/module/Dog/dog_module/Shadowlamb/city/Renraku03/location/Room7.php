<?php
final class PC_Renraku03_Box7 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 9; }
	public function getComputerLevel(SR_Player $player) { return 1.3; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$quest = SR_Quest::getQuest($player, 'Delaware_DallasJ4');
		$quest instanceof Quest_Delaware_DallasJ4;
		$quest->onGetFile($player);
		$this->msg($player, 'file1a');
		$this->msg($player, 'file1b');
// 		$player->message('You find a file: "results2.dbm"');
// 		$player->message('You get the file and store it on your headcomputer.');
		
	}
}

final class Renraku03_Room7 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 90.0; }
	public function getComputers() { return array('Renraku03_Box7'); }
	public function getLockLevel() { return 1.2; }

// 	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0307". It seems locked.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0307. On a desk you see a computer with a screensaver.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>
