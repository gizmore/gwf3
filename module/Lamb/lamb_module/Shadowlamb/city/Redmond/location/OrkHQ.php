<?php
final class Redmond_OrkHQ extends SR_Tower
{
	public function getFoundPercentage() { return 15.00; }
	public function getFoundText(SR_Player $player) { return 'You see a rotten building with lots of garbage in front of it. You hear the noise of Orks grunting.'; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		$party->notice('You easily manage to crack the rotten front door open...');
		$this->teleport($player, 'OrkHQ_Exit');
	}
}
?>