<?php
final class PC_Renraku03_Box4 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 9; }
	public function getComputerLevel(SR_Player $player) { return 1.4; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(100, 200);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayNuyen($nuyen)));
	}
}

final class Renraku03_Room4 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 90.0; }
	public function getComputers() { return array('Renraku03_Box4'); }
	public function getLockLevel() { return 0.9; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0304". It seems locked.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0304. On a desk you see a computer with a screensaver.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>
