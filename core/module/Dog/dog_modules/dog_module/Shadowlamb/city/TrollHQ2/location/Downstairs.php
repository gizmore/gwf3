<?php
final class TrollHQ2_Downstairs extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return "You found a stair that leads down to the partere."; }
	public function getFoundPercentage() { return 50.00; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleportOutside($player, 'TrollHQ_Upstairs');
	}
}
?>
