<?php
final class Renraku02_Room3 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 80.0; }
	public function getLockLevel() { return 0.8; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a room labelled "0203" . It seems locked.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the room labelled 0203. Only some empty desks and a few crates here.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>