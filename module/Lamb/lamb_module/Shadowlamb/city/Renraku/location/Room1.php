<?php
class PC_RenrakuBOX1 extends SR_Computer
{
	public function getMaxAttempts() { return 4; }
	public function getMinHits() { return 10; }
	public function getComputerLevel(SR_Player $player) { return 0.5; }
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(100, 200);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayPrice($nuyen)));
	}
}


class PC_RenrakuBOX2 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 12; }
	public function getComputerLevel(SR_Player $player) { return 0.8; }
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(200, 400);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayPrice($nuyen)));
	}
}


class PC_RenrakuBOX3 extends SR_Computer
{
	public function getMaxAttempts() { return 2; }
	public function getMinHits() { return 15; }
	public function getComputerLevel(SR_Player $player) { return 1.2; }
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(100, 300);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayPrice($nuyen)));
	}
}

final class Renraku_Room1 extends SR_SearchRoom
{
	public function getComputers() { return array('RenrakuBOX1','RenrakuBOX2','RenrakuBOX3'); }
	
	public function isSearchable() { return true; }
	public function getSearchLevel() { return 5; }
	public function getSearchMaxAttemps() { return 1; }
	
	public function getFoundPercentage() { return 50; }
	public function getFoundText(SR_Player $player) { return 'You find a room with several computers. Nobody is around.'; }
	public function getEnterText(SR_Player $player) { return 'You see several computers and a lot of garbage in the corners.'; }
	public function getHelpText(SR_Player $player) { return $player->canHack() ? 'You can use a cyberdeck here to hack into the workstations.' : parent::getHelpText($player); }
}
?>