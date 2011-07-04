<?php
final class PC_Renraku03_Box1 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 14; }
	public function getComputerLevel(SR_Player $player) { return 1.5; }
	
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(200, 300);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayPrice($nuyen)));
	}
}

final class Renraku03_Room1 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 90.0; }
	public function getComputers() { return array('Renraku03_Box1'); }
	public function getLockLevel() { return 0.5; }
	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0301. On a desk you see a computer with a screensaver.'; }
	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0301". It seems locked.'; }
}
?>
