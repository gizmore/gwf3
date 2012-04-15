<?php
final class Renraku_Exit extends SR_Exit
{
// 	public function getFoundText(SR_Player $player) { return 'The exit of the Renraku Tower. Better be sneaky!'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Renraku building.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getExitLocation() { return 'Seattle_Renraku'; }
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		$party->giveKnowledge('places', 'Renraku_Reception');
		return parent::onEnter($player);
	}
}
?>
