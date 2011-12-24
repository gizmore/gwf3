<?php
final class PrisonB2_Exit extends SR_Tower
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'PrisonB2_ExitGuard'); }
	public function getFoundText(SR_Player $player) { return "You found the exit to cell block 2."; }
	public function getFoundPercentage() { return 5.00; }
	public function getEnterText(SR_Player $player) { return "A guard is blocking your way."; }
	public function isExitAllowed(SR_Player $player) { return false; }
	
	public function onEnter(SR_Player $player)
	{
		return $this->teleport($player, 'Prison_Block2', 1);
	}
}
?>