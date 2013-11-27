<?php
final class Redmond_OrkHQ extends SR_Entrance
{
	public function getFoundPercentage() { return 5.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return 'You see a rotten building with lots of garbage in front of it. You hear the noise of Orks grunting.'; }
	
	public function getExitLocation() { return 'OrkHQ_Exit'; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		$this->partyMessage($player, 'cracked');
// 		$party->notice('You easily manage to crack the rotten front door open...');
		$this->teleportInside($player, 'OrkHQ_Exit');
	}
}
?>