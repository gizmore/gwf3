<?php
final class TrollHQ_Downstairs extends SR_Stairs
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return "You found a stair that leads down to the cellars."; }
	public function getFoundPercentage() { return 50.00; }
	public function getExitLocation() { return 'TrollCellar_Upstairs'; }
}
?>
