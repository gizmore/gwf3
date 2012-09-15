<?php
final class Delaware_TrollHQ extends SR_Entrance
{
	public function getFoundPercentage() { return 30.0; }
	public function getLockLevel() { return 0.8; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getExitLocation() { return 'TrollHQ_Exit'; }
}
?>
