<?php
final class TrollHQ_Upstairs extends SR_Stairs
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return "You found a stair that leads up to the second floor."; }
	public function getFoundPercentage() { return 50.00; }
	public function getExitLocation() { return 'TrollHQ2_Downstairs'; }
}
?>
