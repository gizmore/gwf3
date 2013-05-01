<?php
final class Delaware_Prison extends SR_Entrance
{
	public function getFoundPercentage() { return 60; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found the local prison. High walls with a barbwire topping surround it.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getHelpText(SR_Player $player) { return false; }
	public function getEnterText(SR_Player $player) { return false; }
	
	public function getExitLocation() { return 'Prison_Exit'; }
}
?>