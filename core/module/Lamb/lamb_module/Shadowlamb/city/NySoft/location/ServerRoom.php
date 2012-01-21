<?php
final class PC_NySoft_Box1 extends SR_Computer
{
	public function getMaxAttempts() { return 3; }
	public function getMinHits() { return 12; }
	public function getComputerLevel(SR_Player $player) { return 2.6; }
	public function onHacked(SR_Player $player, $hits)
	{
		$nuyen = rand(200, 400);
		$player->giveBankNuyen($nuyen);
		$player->message(sprintf('You managed to transfer %s to your bank account from another.', Shadowfunc::displayNuyen($nuyen)));
	}
}

final class PC_NySoft_Box2 extends SR_Computer
{
	public function getMaxAttempts() { return 2; }
	public function getMinHits() { return 10; }
	public function getComputerLevel(SR_Player $player) { return 2.4; }
	public function onHacked(SR_Player $player, $hits)
	{
		$player->message('You managed to create a backup from a big data server.');
		$player->giveItems(array(SR_Item::createByName('NySoftBackup')), 'hacking a computer');
	}
}

final class NySoft_ServerRoom extends SR_SearchRoom
{
	public function getFoundText(SR_Player $player) { return 'It seems like you found a server room. "BINGO", you think to yourself, while looking innocent.'; }
	public function getLockLevel() { return 3.5; } 
	public function getEnterText(SR_Player $player) { return 'You enter a shady room and hear the buzzing of computers doing their job.'; }
	public function getFoundPercentage() { return 40; }
	public function getComputers() { return array('NySoft_Box1', 'NySoft_Box2'); }
}
?>