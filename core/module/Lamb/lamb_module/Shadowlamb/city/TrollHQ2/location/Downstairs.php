<?php
final class TrollHQ2_Downstairs extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return "You found a stair that leads down to the partere."; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleport($player, 'TrollHQ_Upstairs', 30);
	}
}
?>